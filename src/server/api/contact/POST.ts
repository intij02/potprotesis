import type { Request, Response } from "express";
import nodemailer from "nodemailer";
import { z } from "zod";

const contactSchema = z.object({
  nombre: z.string().trim().min(2).max(120),
  consultorio: z.string().trim().max(120).optional().default(""),
  telefono: z.string().trim().min(7).max(30),
  email: z.string().trim().email().max(160),
  servicio: z.string().trim().max(80).optional().default(""),
  mensaje: z.string().trim().min(10).max(3000),
});

const MAX_REQUESTS_PER_WINDOW = 5;
const RATE_WINDOW_MS = 10 * 60 * 1000;
const rateMap = new Map<string, { count: number; windowStart: number }>();

function getClientIp(req: Request): string {
  const forwarded = req.headers["x-forwarded-for"];
  if (typeof forwarded === "string" && forwarded.length > 0) {
    return forwarded.split(",")[0].trim();
  }
  return req.ip || "unknown";
}

function isRateLimited(ip: string): boolean {
  const now = Date.now();
  const entry = rateMap.get(ip);

  if (!entry || now - entry.windowStart > RATE_WINDOW_MS) {
    rateMap.set(ip, { count: 1, windowStart: now });
    return false;
  }

  entry.count += 1;
  rateMap.set(ip, entry);
  return entry.count > MAX_REQUESTS_PER_WINDOW;
}

function escapeHtml(text: string): string {
  return text
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}

function getTransporter() {
  const host = process.env.SMTP_HOST;
  const port = Number(process.env.SMTP_PORT || 587);
  const user = process.env.SMTP_USER;
  const pass = process.env.SMTP_PASS;

  if (!host || !user || !pass) {
    throw new Error("SMTP configuration is incomplete");
  }

  return nodemailer.createTransport({
    host,
    port,
    secure: port === 465,
    auth: {
      user,
      pass,
    },
  });
}

export default async function handler(req: Request, res: Response) {
  if (req.method !== "POST") {
    return res.status(405).json({ error: "Method not allowed" });
  }

  const ip = getClientIp(req);
  if (isRateLimited(ip)) {
    return res.status(429).json({ error: "Too many requests, please try again later" });
  }

  const parsed = contactSchema.safeParse(req.body);
  if (!parsed.success) {
    return res.status(400).json({ error: "Invalid form data" });
  }

  const { nombre, consultorio, telefono, email, servicio, mensaje } = parsed.data;

  try {
    const transporter = getTransporter();
    const to = process.env.CONTACT_FORM_TO || "contacto@potprotesisdental.com";
    const from = process.env.CONTACT_FORM_FROM || process.env.SMTP_USER!;

    await transporter.sendMail({
      from,
      to,
      replyTo: email,
      subject: `Nuevo mensaje de contacto - ${nombre}`,
      text: [
        `Nombre: ${nombre}`,
        `Consultorio: ${consultorio || "No proporcionado"}`,
        `Telefono: ${telefono}`,
        `Email: ${email}`,
        `Servicio: ${servicio || "No especificado"}`,
        "",
        "Mensaje:",
        mensaje,
      ].join("\n"),
      html: `
        <h2>Nuevo mensaje desde potprotesisdental.com</h2>
        <p><strong>Nombre:</strong> ${escapeHtml(nombre)}</p>
        <p><strong>Consultorio:</strong> ${escapeHtml(consultorio || "No proporcionado")}</p>
        <p><strong>Telefono:</strong> ${escapeHtml(telefono)}</p>
        <p><strong>Email:</strong> ${escapeHtml(email)}</p>
        <p><strong>Servicio:</strong> ${escapeHtml(servicio || "No especificado")}</p>
        <p><strong>Mensaje:</strong></p>
        <p>${escapeHtml(mensaje).replace(/\n/g, "<br/>")}</p>
      `,
    });

    return res.status(200).json({ ok: true });
  } catch (error) {
    console.error("Contact form email error:", error);
    return res.status(500).json({ error: "Unable to send message right now" });
  }
}

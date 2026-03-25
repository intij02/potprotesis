/**
 * Google Maps API Configuration Endpoint
 *
 * Returns the Google Maps API key for client-side map rendering.
 * The API key is stored securely in the secrets manager.
 */

import { getSecret } from '#airo/secrets';

function getAllowedOrigins(): string[] {
  const configuredOrigins = process.env.ALLOWED_MAPS_ORIGINS;
  if (!configuredOrigins) {
    return [];
  }

  return configuredOrigins
    .split(',')
    .map((origin) => origin.trim())
    .filter(Boolean);
}

export function GET(request: Request) {
  const apiKey = getSecret('GOOGLE_MAPS_API_KEY');

  if (!apiKey) {
    return Response.json(
      { error: 'Google Maps API key not configured' },
      { status: 500 }
    );
  }

  const allowedOrigins = getAllowedOrigins();
  const requestOrigin = request.headers.get('origin');

  if (allowedOrigins.length > 0 && requestOrigin && !allowedOrigins.includes(requestOrigin)) {
    return Response.json({ error: 'Forbidden' }, { status: 403 });
  }

  return Response.json(
    { apiKey },
    {
      headers: {
        'Cache-Control': 'no-store',
      },
    }
  );
}

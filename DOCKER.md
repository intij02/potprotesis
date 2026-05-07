# Entorno local con Docker

## 1. Preparar variables de entorno

Copie `.env.docker` a `.env`.

## 2. Levantar contenedores

```bash
docker compose up -d --build
```

La app quedará en:

```text
http://localhost:8080
```

MySQL quedará expuesto en:

```text
localhost:3307
```

## 3. Instalar dependencias si hace falta

Si `vendor/` no existe o necesita regenerarlo:

```bash
docker compose exec app composer install
```

## 4. Ejecutar migraciones

```bash
docker compose exec app php spark migrate
```

## 5. Apagar el entorno

```bash
docker compose down
```

Para borrar también la base de datos local:

```bash
docker compose down -v
```

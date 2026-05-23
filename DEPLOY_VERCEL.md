# Vercel Deployment — Sweet Crumbs

## Critical dashboard settings

In **Vercel → Project → Settings → Build & Deployment**:

| Setting | Value |
|---------|--------|
| Framework Preset | **Other** |
| Root Directory | `.` (repo root) |
| **Output Directory** | **EMPTY** (never `public`) |
| Build Command | empty, or `node scripts/vercel-vite.mjs` |
| Install Command | empty, or `composer install --no-dev --optimize-autoloader && npm ci` |
| Node.js Version | **22.x** |

If **Output Directory** is `public`, Vercel serves `index.php` as a **static download** instead of running PHP.

## How routing works

```
Static files (CSS, JS, images)  →  @vercel/static from public/**
All other URLs (/, /products)   →  api/index.php → public/index.php (Laravel)
```

## Build separation

| Phase | Command |
|-------|---------|
| Node (Vite) | `node scripts/vercel-vite.mjs` |
| PHP (Composer) | `composer run vercel` during vercel-php build |

`package.json` must **not** include `php artisan` in npm scripts.

## Redeploy checklist

1. Push latest `main` from GitHub
2. **Redeploy without build cache**
3. Confirm Output Directory is blank in dashboard
4. Set env vars: `APP_KEY`, `APP_URL`, `DB_*`, etc.

## Local smoke test

```bash
composer install
npm ci
npm run build
php artisan serve
```

Visit http://127.0.0.1:8000 — site should render with assets from `public/build/`.

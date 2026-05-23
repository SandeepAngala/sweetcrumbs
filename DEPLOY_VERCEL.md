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

## Fix the orange warning (from your screenshots)

You see: **"Configuration Settings in the current Production deployment differ from your current Project Settings."**

That means the **live site** was built with **old settings**, even though your dashboard now looks correct.

### Step 1 — Build and Deployment (your screenshot)

Your **Project Settings** are correct:

| Setting | Your value | Status |
|---------|------------|--------|
| Framework Preset | Other | OK |
| Build Command override | OFF, empty | OK |
| **Output Directory override** | OFF, empty | OK |
| Install Command override | OFF, empty | OK |
| Root Directory | `./` | OK |

1. Click **Production Overrides** (expand it).
2. If you see **Output Directory = `public`** or a build command with `php artisan` — that is the bug. Clear those overrides or turn overrides OFF.
3. Leave all four **Override** toggles **OFF** so `vercel.json` in Git controls the build.

### Step 2 — Node.js Version (your screenshot)

1. Open **Project Settings** (not Production Overrides).
2. Set **Node.js Version** to **22.x**.
3. Save.
4. Expand **Production Overrides** — if Node version is pinned to 18.x there, remove it or redeploy so production matches 22.x.

### Step 3 — Fresh production deploy

1. **Deployments** tab → latest deployment from `main`.
2. ⋮ menu → **Redeploy**.
3. **Uncheck** “Use existing Build Cache”.
4. Confirm redeploy.

Or push any small commit to `main` to trigger a new Git deployment.

### Step 4 — Environment variables

**Settings → Environment Variables** (Production):

- `APP_KEY` (required)
- `APP_URL` = your Vercel URL (e.g. `https://sweetcrumbs.vercel.app`)
- Database vars if you use a remote DB (SQLite does not work on Vercel serverless — use MySQL/Postgres)

## Redeploy checklist

1. Push latest `main` from GitHub (includes `vercel.json` with `builds` + `vercel-php@0.7.4`)
2. Clear **Production Overrides** if they conflict
3. Node.js **22.x** in Project Settings
4. **Redeploy without build cache**
5. Confirm Output Directory override stays **OFF**
6. Set env vars: `APP_KEY`, `APP_URL`, `DB_*`, etc.

## Local smoke test

```bash
composer install
npm ci
npm run build
php artisan serve
```

Visit http://127.0.0.1:8000 — site should render with assets from `public/build/`.

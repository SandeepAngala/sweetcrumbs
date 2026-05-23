# Vercel Deployment — Sweet Crumbs

## Dashboard (Framework Preset)

| Setting | Value |
|---------|--------|
| Framework Preset | **Other** (not Vite / React / Next.js) |
| Output Directory override | **OFF** / empty |
| Build Command override | **OFF** / empty |
| Node.js Version | **22.x** |

## How it works (`vercel.json`)

1. **`@vercel/static-build`** — runs `npm run build` → Vite outputs to `public/build`
2. **`vercel-php@0.7.4`** — executes `public/index.php` (Laravel)
3. **Routes** — `/build/*` → static assets; everything else → `public/index.php`

> Uses `vercel-php@0.7.4` (not 0.6.0) because Node 18 is discontinued on Vercel.

## Redeploy

1. Push `main` from GitHub
2. **Deployments → Redeploy → uncheck “Use existing Build Cache”**
3. Set env: `APP_KEY`, `APP_URL`, database credentials

## Environment variables (Production)

- `APP_KEY` — required
- `APP_URL` — your Vercel URL
- `DB_*` — use MySQL/Postgres (SQLite does not persist on serverless)

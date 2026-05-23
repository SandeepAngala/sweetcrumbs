# Sweet Crumbs — Vercel Deployment (Final)

## Warning (safe to ignore)

> WARNING! Due to `builds` existing in your configuration file, the Build and Development Settings defined in your Project Settings will not apply.

**Normal for Laravel + vercel-php.** `vercel.json` intentionally controls the build.

## Vercel dashboard

| Setting | Value |
|---------|--------|
| Framework Preset | **Other** |
| Output Directory override | **OFF** (empty) |
| Build Command override | **OFF** (empty) |
| Node.js Version | **22.x** |

## `vercel.json` behavior

1. `@vercel/static-build` → runs `npm run build` → Vite → `public/build`
2. `vercel-php@0.7.4` → executes `public/index.php` (Laravel)
3. Routes: `/build/*` = assets; all else → Laravel

> Uses **0.7.4** (not 0.6.0) — Node 18 runtime is discontinued on Vercel.

## Local build before deploy

```bash
composer install
npm ci
npm run build
```

## Redeploy

1. Push `main` to GitHub
2. Vercel → **Deployments** → **Redeploy**
3. **Clear Cache & Redeploy**
4. Env vars: `APP_KEY`, `APP_URL`, `DB_*` (use MySQL/Postgres, not SQLite)

## Verify after deploy

- [ ] Status **Ready** (warning is OK)
- [ ] Homepage shows HTML (no `.php` download)
- [ ] CSS/JS load from `/build/`
- [ ] `/products`, `/login`, `/admin` work
- [ ] `/api/v1/products` returns JSON

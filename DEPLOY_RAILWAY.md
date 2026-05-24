# Sweet Crumbs — Railway deployment

## Critical: HTTPS and `APP_URL`

Railway serves your app over **HTTPS**. If `APP_URL` uses `http://`, Laravel generates `http://` asset URLs (`/build/assets/...`). Browsers **block** those as mixed content when the page is `https://`, so CSS/JS never load.

Set in Railway → **Variables**:

| Variable | Value |
|----------|--------|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | *(from `php artisan key:generate --show`)* |
| `APP_URL` | `https://sweetcrumbs-production-ec96.up.railway.app` |
| `FORCE_HTTPS` | `true` |
| `BAKERY_PREFER_LOCAL_MEDIA` | `false` |

`FORCE_HTTPS` + trusted proxies (configured in code) ensure `@vite` and `route()` use **https://**.

## Database (empty homepage sections)

Add MySQL/PostgreSQL on Railway and set `DATABASE_URL` (or `DB_*` vars). After first deploy:

```bash
railway run php artisan migrate --force
railway run php artisan db:seed --force
```

Without seeding, products/categories will be empty even when CSS works.

## Build

`railway.toml` runs:

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan config:cache
```

`public/build` is also committed to git as a fallback if `npm run build` fails on a deploy.

## Verify after deploy

1. Open DevTools → **Network** → reload.
2. `app-*.css` and `app-*.js` must be **200** and URLs must start with **`https://`**.
3. No mixed-content warnings in the console.

## Local production check

```bash
APP_ENV=production APP_URL=https://your-app.up.railway.app php artisan serve
npm run build
```

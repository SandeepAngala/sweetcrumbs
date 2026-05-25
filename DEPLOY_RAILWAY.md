# MANA OORU MANA TEA — Railway deployment

## Environment variables

Set in Railway → **Variables** (web service):

| Variable | Value |
|----------|--------|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | *(from `php artisan key:generate --show`)* |
| `APP_URL` | `https://sweetcrumbs-production-ec96.up.railway.app` |
| `FORCE_HTTPS` | `true` |
| `BAKERY_PREFER_LOCAL_MEDIA` | `false` |
| `CACHE_STORE` | `file` |
| `SESSION_DRIVER` | `file` |
| `QUEUE_CONNECTION` | `sync` |
| `LOG_CHANNEL` | `stderr` |

**Database:** Add **MySQL** or **PostgreSQL** in Railway and **link** it to the web service. Railway injects `DATABASE_URL` — the app uses it automatically. Do **not** set `DB_HOST=127.0.0.1` or XAMPP credentials.

## Empty products / categories (most common)

The UI works but sections say “No products found” because the **production database has no seeded data**.

On each deploy, `scripts/railway-start.sh` runs:

1. `migrate --force` — creates tables  
2. `db:seed-if-empty` — seeds **64 products**, 6 categories, banners, CMS, reviews when `products` table is empty  

**Redeploy** after linking a database, or seed manually once:

```bash
railway run php artisan db:seed-if-empty
# or full seed:
railway run php artisan db:seed --force
```

After rebrand or content fixes (tea blogs, reviews, combo builder, images):

```bash
railway run php artisan db:seed --class=ContentRefreshSeeder --force
railway run php artisan cache:clear
railway run php artisan view:clear
railway run php artisan storage:link
```

Verify counts:

```bash
railway run php scripts/db-check.php
```

Expected: **64 products**, **6 categories**.

## HTTPS / Vite assets

If CSS/JS are missing, set `APP_URL` to **`https://`** (not `http://`) and `FORCE_HTTPS=true`. Browsers block mixed-content `http://` assets on HTTPS pages.

## Fix 500 errors

1. Link a database service (`DATABASE_URL` must appear in Variables).  
2. Set `CACHE_STORE=file` and `SESSION_DRIVER=file`.  
3. Check deploy logs for migration/seed errors.

## APIs

After seeding:

- `GET /api/v1/products` — product list  
- `GET /api/v1/categories` — categories  

Empty `[]` response = database not seeded.

## Admin login (after seed)

- `admin@manaoorumanatea.com` / `password`

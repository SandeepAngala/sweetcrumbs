# Local development (MANA OORU MANA TEA)

## Quick start (XAMPP + MySQL)

1. Start **Apache** and **MySQL** in XAMPP.
2. Create database `manaoorumanatea` in phpMyAdmin (utf8mb4).
3. Configure `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manaoorumanatea
DB_USERNAME=root
DB_PASSWORD=
```

4. Run:

```bash
composer install
cp .env.example .env   # if needed
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan optimize:clear
npm ci
composer dev
```

Verify data: `php scripts/db-check.php` (expect 64 products, 6 categories).

If the homepage is empty after migrating to MySQL, seeders likely did not run — `migrate:fresh --seed` repopulates all storefront data.

Open **http://127.0.0.1:8000** — not `http://localhost:5173` (that URL is only the Vite dev server).

## Why styles were missing

Laravel uses `public/hot` while Vite is running. If Vite stops but `public/hot` remains (wrong port, e.g. `5174`), Laravel still points at a dead dev server and CSS/JS fail to load.

`npm run dev` now runs `predev` to remove a stale `public/hot` first. `vite.config.js` pins **127.0.0.1:5173** to match `APP_URL`.

## Commands

| Command | Use |
|---------|-----|
| `composer dev` | Laravel + Vite (Windows-friendly) |
| `composer dev:full` | + queue + Pail (Linux/macOS only; Pail needs `pcntl`) |
| `php artisan serve --host=127.0.0.1 --port=8000` | Backend only |
| `npm run dev` | Vite only (run alongside `artisan serve`) |
| `npm run build` | Production assets into `public/build` (no Vite server needed) |

## Defaults

- **APP_URL:** `http://127.0.0.1:8000`
- **Admin:** `admin@manaoorumanatea.com` / `password`

# Local development (Sweet Crumbs)

## Quick start

```bash
composer install
cp .env.example .env   # if needed
php artisan key:generate
php artisan migrate --seed
npm ci
composer dev
```

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
- **Admin:** `admin@sweetcrumbs.com` / `password`

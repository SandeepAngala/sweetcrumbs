# Sweet Crumbs — Enterprise Laravel Backend

Production-ready Laravel 12 MVC backend for the Sweet Crumbs premium bakery & café platform.

## Architecture

```
app/
├── Http/
│   ├── Controllers/Api/     # REST API (Sanctum)
│   ├── Controllers/Admin/   # Admin panel
│   ├── Middleware/          # admin, role, permission
│   ├── Requests/Api/        # Form validation
│   └── Resources/           # API transformers
├── Models/
├── Repositories/            # Repository pattern
├── Services/                # Business logic
├── Policies/
└── Notifications/
routes/
├── web.php                  # Customer-facing web
├── api.php                  # /api/v1/*
└── admin.php                # /admin/*
```

## Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

**Default admin:** `admin@sweetcrumbs.com` / `password`  
**Staff:** `staff@sweetcrumbs.com` / `password`

## API (`/api/v1`)

| Method | Endpoint | Auth |
|--------|----------|------|
| POST | `/auth/register` | Public |
| POST | `/auth/login` | Public |
| GET | `/products` | Public |
| GET | `/categories` | Public |
| GET | `/cart` | Sanctum |
| POST | `/orders` | Sanctum |
| POST | `/payments/verify` | Sanctum |

Pass token: `Authorization: Bearer {token}`

## Roles

- `super_admin` — full access
- `admin` — catalog, orders, customers
- `staff` — orders, inventory
- `customer` — storefront & API

## Payments

Configure in `.env`:

```
RAZORPAY_KEY=
RAZORPAY_SECRET=
STRIPE_KEY=
STRIPE_SECRET=
```

Webhooks: `POST /api/v1/payments/webhook/{razorpay|stripe}`

## Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## Tests

```bash
php artisan test
```

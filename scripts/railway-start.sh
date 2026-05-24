#!/bin/sh
set -e

# Clear build-time caches so Railway runtime env vars (DATABASE_URL, APP_KEY) apply.
php artisan config:clear
php artisan cache:clear
php artisan view:clear

php artisan migrate --force --no-interaction

php artisan db:seed-if-empty --no-interaction

php artisan storage:link 2>/dev/null || true

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"

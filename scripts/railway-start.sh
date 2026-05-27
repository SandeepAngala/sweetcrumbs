#!/bin/sh
# Trigger automatic Railway redeployment
set -e

# Clear build-time caches so Railway runtime env vars (DATABASE_URL, APP_KEY) apply.
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan storage:link 2>/dev/null || true

# Run migrations and seeding asynchronously in the background.
# This prevents MongoDB TLS handshake issues or temporary connection drops
# from blocking the web server startup and failing the Railway health check.
(
    # Simple retry loop for database connection/migration safety
    for i in 1 2 3 4 5; do
        if php artisan migrate --force --no-interaction; then
            php artisan db:seed-if-empty --no-interaction || true
            break
        fi
        sleep 5
    done
) > /dev/null 2>&1 &

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8000}"

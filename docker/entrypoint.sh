#!/bin/bash
set -e

# Wait for MySQL to be ready (extra safety on top of healthcheck)
until php artisan migrate --force 2>/dev/null; do
    echo "Waiting for database to be ready..."
    sleep 3
done

# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink if not present
php artisan storage:link 2>/dev/null || true

exec "$@"

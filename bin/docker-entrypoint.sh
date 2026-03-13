#!/usr/bin/env bash
set -e

echo "Running migrations..."
php artisan migrate --force

echo "Caching configuration loaded with runtime environment variables..."
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "Starting server..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}

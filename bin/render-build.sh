#!/usr/bin/env bash
# exit on error
set -o errexit

echo "Installing PHP dependencies..."
composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

echo "Installing Node.js dependencies..."
npm install

echo "Building frontend assets..."
npm run build

echo "Clearing caches..."
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "Running migrations..."
php artisan migrate --force

echo "Build complete."

#!/usr/bin/env bash

set -e

echo "Running composer..."
composer install --no-dev --optimize-autoloader

echo "Generating application key..."
php artisan key:generate --show

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

echo "Installing Node dependencies..."
npm ci

echo "Building front-end assets..."
npm run build

echo "Starting PHP-FPM..."
php-fpm &

echo "Starting Nginx..."
nginx -g "daemon off;"

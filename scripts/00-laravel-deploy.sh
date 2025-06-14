#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

echo "generating application key..."
php artisan key:generate --show

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Resetting database (fresh migrate with seed)..."
php artisan migrate:fresh --seed --force

echo "Creating symbolic link..."
php artisan storage:link

chown -R www-data:www-data /var/www/html/public/storage
chmod -R 755 /var/www/html/public/storage

ls -lR /var/www/html/public
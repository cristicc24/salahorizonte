#!/usr/bin/env bash

set -e

echo "🔧 Verificando si index.php existe..."
if [ -f /var/www/html/public/index.php ]; then
  echo "✅ index.php encontrado"
else
  echo "❌ index.php NO existe"
fi

echo "🔧 Verificando contenido de /etc/nginx/conf.d/default.conf"
cat /etc/nginx/conf.d/default.conf

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


echo "Starting Nginx..."
nginx -g "daemon off;"

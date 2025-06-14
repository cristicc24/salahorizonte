#!/usr/bin/env bash
set -e

echo "🔧 Ejecutando setup Laravel..."
composer install --no-dev --optimize-autoloader

php artisan key:generate --show
php artisan config:cache
php artisan route:cache
php artisan migrate --force
php artisan db:seed --force

echo "✅ Laravel listo."

echo "🔍 Verificando existencia de index.php..."
if [ -f /var/www/html/public/index.php ]; then
  echo "✅ index.php encontrado"
else
  echo "❌ index.php no existe. Algo falló."
  exit 1
fi

echo "📄 nginx.conf cargado:"
cat /etc/nginx/conf.d/default.conf

echo "🚀 Iniciando servicios..."
php-fpm &
nginx -g "daemon off;"

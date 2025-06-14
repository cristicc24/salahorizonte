# Etapa 1: Compilar frontend con Vite
FROM node:18 AS frontend

WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources

RUN npm install && npm run build

# Etapa 2: App Laravel + PHP-FPM + Nginx
FROM php:8.2-fpm

# Instalar dependencias del sistema y Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    git unzip curl libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql gd zip mbstring exif

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código Laravel
WORKDIR /var/www/html
COPY . .

# Copiar build de frontend
COPY --from=frontend /app/public/build ./public/build

# Preparar Laravel
RUN composer install --no-dev --optimize-autoloader \
 && php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Copiar config de Nginx
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

# Copiar script de inicio
COPY ./scripts/00-laravel-deploy.sh /start.sh
RUN chmod +x /start.sh

# Exponer puerto
EXPOSE 80

RUN chown -R www-data:www-data /var/www/html

# Forzar reemplazo de punto de entrada
ENTRYPOINT ["/start.sh"]

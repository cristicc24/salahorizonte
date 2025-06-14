# Etapa 1: Build frontend
FROM node:18 AS frontend
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources
RUN npm install && npm run build

# Etapa 2: App PHP + Nginx
FROM php:8.2-fpm

# Instalar extensiones y Nginx
RUN apt-get update && apt-get install -y \
    nginx \
    git unzip curl libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql gd zip mbstring exif

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader
COPY --from=frontend /app/public/build ./public/build

RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Copiar configuración de Nginx
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

# Copiar script de arranque
COPY ./scripts/00-laravel-deploy.sh /start.sh
RUN chmod +x /start.sh

# Exponer el puerto que Nginx va a servir
EXPOSE 80

CMD ["/00-laravel-deploy.sh"]

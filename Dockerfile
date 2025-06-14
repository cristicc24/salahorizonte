# Etapa 1: Construcción de assets con Node
FROM node:18 AS frontend

WORKDIR /app

COPY package*.json vite.config.js ./
COPY resources ./resources

RUN npm install
RUN npm run build


# Etapa 2: Backend con PHP-FPM y Nginx
FROM php:8.2-fpm AS backend

# Instalar extensiones necesarias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \                 
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

# Configurar Nginx
COPY ./docker/nginx.conf /etc/nginx/nginx.conf

# Arranque de servicios
CMD ["php-fpm"]

FROM richarvey/nginx-php-fpm:3.1.6
WORKDIR /var/www/html

# Instalar Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Instalar la extensión bcmath
RUN docker-php-ext-install bcmath

COPY . .

# Dar permisos de ejecución al script
RUN chmod +x scripts/00-laravel-deploy.sh

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]
ARG PHP_VERSION=8.4-fpm-alpine

FROM php:${PHP_VERSION} AS php

RUN apk add --no-cache \
    nginx \
    supervisor \
    linux-headers \
    libzip-dev \
    zip \
    unzip \
    git \
    $PHPIZE_DEPS \
    && docker-php-ext-install pdo_mysql bcmath zip \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && php artisan storage:link \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80
CMD ["supervisord", "-c", "/etc/supervisord.conf"]

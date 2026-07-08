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
    gettext \
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
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf

EXPOSE 80
RUN echo "#!/bin/sh" > /start.sh \
    && echo "export PORT=\${PORT:-80}" >> /start.sh \
    && echo "envsubst < /etc/nginx/http.d/default.conf > /tmp/nginx.conf && cp /tmp/nginx.conf /etc/nginx/http.d/default.conf" >> /start.sh \
    && echo "envsubst < /etc/nginx/conf.d/default.conf > /tmp/nginx2.conf && cp /tmp/nginx2.conf /etc/nginx/conf.d/default.conf" >> /start.sh \
    && echo "php artisan migrate --force 2>/dev/null" >> /start.sh \
    && echo "supervisord -c /etc/supervisord.conf" >> /start.sh \
    && chmod +x /start.sh

CMD ["/start.sh"]

ARG PHP_VERSION=8.5-fpm-alpine

FROM php:${PHP_VERSION}

WORKDIR /var/www/html

RUN apk update \
    && apk add git

COPY --from=composer:2.9 /usr/bin/composer /usr/local/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN --mount=type=cache,target=/tmp/ipe-cache \
    install-php-extensions pdo_pgsql zip

COPY . .

RUN php -r "file_exists('.env') || copy('.env.example', '.env');"

RUN --mount=type=cache,target=/root/.composer \
    composer install --no-dev --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan key:generate

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

RUN chown -R www-data:www-data /var/www

USER www-data

ENTRYPOINT ["/entrypoint.sh"]
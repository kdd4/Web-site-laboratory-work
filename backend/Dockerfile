ARG PHP_VERSION=8.5-fpm-alpine

FROM php:${PHP_VERSION}

WORKDIR /var/www/html

RUN apk update \
    && apk add git

COPY --from=composer:2.9 /usr/bin/composer /usr/local/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN sed -i 's/;clear_env = no/clear_env = no/' /usr/local/etc/php-fpm.d/www.conf

RUN install-php-extensions pdo_pgsql gmp

COPY composer.json composer.lock ./
RUN composer install

COPY src .

#RUN apt-get install -y curl \
#    && curl -o /usr/local/etc/php/browscap.ini "https://browscap.org/stream?q=PHP_BrowsCapINI" \
#    && echo "browscap = /usr/local/etc/php/browscap.ini" > /usr/local/etc/php/conf.d/browscap.ini


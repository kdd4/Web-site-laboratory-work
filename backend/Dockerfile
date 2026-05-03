ARG PHP_VERSION=8.5-fpm

FROM php:${PHP_VERSION}

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && sed -i 's/;clear_env = no/clear_env = no/' /usr/local/etc/php-fpm.d/www.conf

RUN apt-get install -y curl \
    && curl -o /usr/local/etc/php/browscap.ini "https://browscap.org/stream?q=PHP_BrowsCapINI" \
    && echo "browscap = /usr/local/etc/php/browscap.ini" > /usr/local/etc/php/conf.d/browscap.ini
ARG PHP_VERSION=8.5-fpm

FROM php:${PHP_VERSION}

WORKDIR /var/www/html

RUN apt-get update && apt-get -y install git

COPY --from=composer:2.9 /usr/bin/composer /usr/local/bin/composer

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && sed -i 's/;clear_env = no/clear_env = no/' /usr/local/etc/php-fpm.d/www.conf

COPY composer.json composer.lock ./
RUN composer install

COPY src .

#RUN apt-get install -y curl \
#    && curl -o /usr/local/etc/php/browscap.ini "https://browscap.org/stream?q=PHP_BrowsCapINI" \
#    && echo "browscap = /usr/local/etc/php/browscap.ini" > /usr/local/etc/php/conf.d/browscap.ini


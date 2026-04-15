ARG PHP_VERSION=8.5-fpm

FROM php:${PHP_VERSION}

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

ENV DB_DSN="pgsql:host=database;port=5432;dbname=${POSTGRES_DB};user=${POSTGRES_USER};password=${POSTGRES_PASSWORD}"
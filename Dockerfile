ARG NODE_VERSION=25-alpine
ARG PHP_VERSION=8.5-fpm-alpine

FROM node:${NODE_VERSION} AS builder

WORKDIR /app

COPY ./frontend/package.json ./frontend/package-lock.json ./

RUN --mount=type=cache,target=/root/.npm npm clean-install

COPY ./frontend .

RUN npm run build


FROM php:${PHP_VERSION} AS runner

WORKDIR /var/www/html

COPY --from=builder /app/dist ./public
COPY ./src .
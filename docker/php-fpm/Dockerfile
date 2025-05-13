ARG PHP_VERSION=8.4
ARG PHP_EXTENSIONS="pdo_mysql"

FROM php:${PHP_VERSION}-fpm-bookworm

ARG PHP_EXTENSIONS

RUN <<EOT
set -xe
mv "${PHP_INI_DIR}/php.ini-development" "${PHP_INI_DIR}/php.ini"
docker-php-ext-install ${PHP_EXTENSIONS}
EOT

WORKDIR /app

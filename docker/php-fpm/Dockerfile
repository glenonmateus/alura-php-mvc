ARG PHP_VERSION=8.4
ARG PHP_EXTENSIONS="pdo_mysql"

FROM php:${PHP_VERSION}-fpm-bookworm

ARG PHP_EXTENSIONS

RUN <<EOT
set -xe
mv "${PHP_INI_DIR}/php.ini-development" "${PHP_INI_DIR}/php.ini"
cat <<EOF > "${PHP_INI_DIR}/conf.d/10-session.ini"
session.cookie_httponly=1
session.cookie_secure=1
session.cookie_samesite=Strict
EOF
docker-php-ext-install ${PHP_EXTENSIONS}
EOT

WORKDIR /app

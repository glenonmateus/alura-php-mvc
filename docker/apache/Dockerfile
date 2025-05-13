ARG PHP_VERSION=8.4
ARG PHP_EXTENSIONS="pdo_mysql"
ARG APACHE_MODS="headers rewrite actions"

FROM php:${PHP_VERSION}-apache

ARG PHP_VERSION
ARG PHP_EXTENSIONS
ARG APACHE_MODS

RUN <<EOT
set -xe
mv "${PHP_INI_DIR}"/php.ini-development "${PHP_INI_DIR}"/php.ini
cat <<EOF > /etc/apache2/sites-available/vhosts.conf
<VirtualHost *:80>
DocumentRoot "/app/public"
DirectoryIndex index.php index.html
<Directory /app/public>
    Options +Indexes +FollowSymLinks +MultiViews
    # Options -Indexes +FollowSymLinks +MultiViews
    AllowOverride All
    Require all granted
</Directory>
</VirtualHost>
EOF
a2dissite 000-default
a2ensite vhosts
a2enmod "${APACHE_MODS}"
docker-php-ext-install "${PHP_EXTENSIONS}"
EOT

WORKDIR /app

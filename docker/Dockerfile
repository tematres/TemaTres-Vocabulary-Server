# TemaTres in a container: PHP + Apache with the code of this repository.
# Build from the repository root:  docker build -f docker/Dockerfile -t tematres .
# (or use docker/docker-compose.yml, which also starts a database).
# The image contains the code of the checked out version, so nothing has to be edited when a new TemaTres version is released.
ARG PHP_VERSION=8.3
FROM php:${PHP_VERSION}-apache

# mysqli for the database (curl, xml and mbstring are already part of the php image); mod_rewrite for the clean URLs (.htaccess);
# php.ini-production: errors are written to the log (docker compose logs app), not shown to visitors
RUN docker-php-ext-install mysqli \
 && a2enmod rewrite \
 && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY . /var/www/html/
# Database settings are read from environment variables (see docker/db.tematres.php), not from the sample file in the repository
COPY docker/db.tematres.php /var/www/html/vocab/db.tematres.php

# The web directory is /vocab/ (TemaTres loads its libraries from ../common/)
EXPOSE 80
HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=5 \
    CMD php -r 'exit(@file_get_contents("http://127.0.0.1/vocab/index.php")===false ? 1 : 0);'

FROM dunglas/frankenphp

ENV SERVER_NAME=:80

EXPOSE 80

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    git \
    unzip

RUN install-php-extensions \
    gd \
    opcache

# Enable PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && mkdir vendor \
    && chown www-data:www-data vendor

COPY . /app

RUN composer install --no-cache --no-dev --no-scripts --no-autoloader --ansi --no-interaction
RUN composer dump-autoload -o

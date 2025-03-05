FROM dunglas/frankenphp

ENV SERVER_NAME=:80

EXPOSE 80

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Get NodeJS
COPY --from=node:20-slim /usr/local/bin /usr/local/bin
# Get npm
COPY --from=node:20-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    git \
    unzip

RUN install-php-extensions \
    gd \
    opcache

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && mkdir vendor \
    && chown www-data:www-data vendor

COPY . /app

RUN composer install --no-cache --no-dev --no-scripts --no-autoloader --ansi --no-interaction
RUN composer dump-autoload -o

RUN npm install \
    && npm run build

## ver .env
FROM php:8.4-fpm-alpine

RUN apk upgrade --no-cache \
    && apk add --no-cache --virtual .build-deps \
    postgresql-dev \
    && docker-php-ext-install mbstring pdo pdo_pgsql opcache \
    && apk del --no-cache .build-deps \
    && apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    libpq

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.enable_cli=0'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=20000'; \
    echo 'opcache.validate_timestamps=1'; \
    echo 'opcache.revalidate_freq=0'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

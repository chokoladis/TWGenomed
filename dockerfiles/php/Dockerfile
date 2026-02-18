FROM php:8.4-fpm-alpine
WORKDIR /var/www/twgenomed

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV PATH="$PATH:/usr/local/bin"

RUN set -eux; \
    apk add --virtual .build-deps \
            autoconf \
            build-base \
            linux-headers \
            zlib-dev \
            libzip-dev \
            oniguruma-dev \
            icu-dev \
            libxml2-dev \
            curl-dev

RUN apk add bash \
        libzip \
        zlib \
        icu-libs \
        libxml2 \
        curl; \
    docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        bcmath \
        intl \
        sockets \
        pcntl \
        curl; \
    apk del .build-deps; \
    apk add --no-cache ca-certificates && update-ca-certificates
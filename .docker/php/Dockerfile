FROM php:8.0-cli-alpine

ENV XDEBUG_VERSION=3.0.3 \
    COMPOSER_ALLOW_SUPERUSER=1

RUN apk --no-cache add \
        mysql-dev \
        oniguruma-dev \
        icu-dev \
        gettext-dev \
        g++ \
        autoconf \
        make \
        git && \
    docker-php-ext-install \
        opcache \
        gettext \
        intl \
        pdo_mysql \
        pcntl \
        > /dev/null && \
    pecl install xdebug-$XDEBUG_VERSION > /dev/null && \
        docker-php-ext-enable xdebug > /dev/null && \
        apk del g++ autoconf make && \
        rm -r /tmp/pear/*

RUN curl -sS https://getcomposer.org/installer | php -- --2 --install-dir=/usr/local/bin --filename=composer

COPY .docker/php/php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www

COPY ./src /var/www/
# RUN composer install --prefer-dist

RUN rm -rf ./* && \
    addgroup -g 1000 appuser && \
    adduser -D -u 1000 -G appuser appuser && \
    chown -R appuser:appuser .
USER appuser

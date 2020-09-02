FROM php:7.4-cli-alpine

ENV XDEBUG_VERSION=2.9.6 \
    VERSION_PRESTISSIMO_PLUGIN=^0.3.9 \
    COMPOSER_ALLOW_SUPERUSER=1

RUN apk --no-cache add \
        postgresql-dev \
        oniguruma-dev \
        icu-dev \
        gettext-dev \
        g++ \
        autoconf \
        make \
        git && \
    docker-php-ext-install \
        mbstring \
        opcache \
        gettext \
        intl \
        pdo_pgsql \
        sockets \
        pcntl \
        > /dev/null && \
    pecl install xdebug-$XDEBUG_VERSION > /dev/null && \
        docker-php-ext-enable xdebug > /dev/null && \
        apk del g++ autoconf make && \
        rm -r /tmp/pear/* && \
        mkdir -p /var/log/bot && \
        touch /var/log/bot/xdebug.log && \
        echo -e "xdebug.remote_port = 9001\n\
xdebug.idekey = \"PHPSTORM\"\n\
xdebug.remote_enable=on\n\
xdebug.remote_connect_back=0\n\
" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer global require --optimize-autoloader \
        "hirak/prestissimo:${VERSION_PRESTISSIMO_PLUGIN}" && \
    composer global dumpautoload --optimize

WORKDIR /var/www

COPY . /var/www/
RUN composer install --prefer-dist

RUN rm -rf ./* && \
    addgroup -g 1000 appuser && \
    adduser -D -u 1000 -G appuser appuser && \
    chown -R appuser:appuser .
USER appuser

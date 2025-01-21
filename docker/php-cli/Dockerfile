FROM php:8.3-cli-alpine

RUN apk add --no-cache autoconf g++ make \
    && rm -rf /tmp/pear

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN apk add unzip

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

WORKDIR /composer-package
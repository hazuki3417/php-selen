ARG IMAGE_NAME=php-selen
ARG ENVIRONMENT=develop

ARG RESOURCE_DIR=docker/${ENVIRONMENT}/${IMAGE_NAME}
ARG SRC_CONFIG_DIR_PATH=${RESOURCE_DIR}/config
ARG DST_CONFIG_DIR_PATH=/usr/local/etc

FROM php:8.1-alpine
ARG SRC_CONFIG_DIR_PATH
ARG DST_CONFIG_DIR_PATH

RUN apk add --update --no-cache \
        autoconf \
        g++ \
        gcc \
        linux-headers \
        make \
        openssl-dev

RUN pecl install \
        xdebug

RUN rm -rfv ${DST_CONFIG_DIR_PATH}/php/conf.d

COPY ${SRC_CONFIG_DIR_PATH}/php/conf.d ${DST_CONFIG_DIR_PATH}/php/conf.d

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer --version

WORKDIR /var/www/html

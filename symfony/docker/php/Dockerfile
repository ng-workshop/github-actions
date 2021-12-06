FROM php:8.1-fpm-alpine

ARG GROUP_ID=1000
ARG USER_ID=1000

ENV APP_ENV dev
ENV COMPOSER_HOME /var/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ADD ./conf.d /usr/local/etc/php/conf.d

RUN apk update \
    && apk add --no-cache --virtual build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        libzip-dev \
        zlib-dev \
    && apk add --no-cache  \
        curl \
        git \
        icu \
        libzip \
        make \
        postgresql-dev \
        shadow \
        sudo \
        zlib \
    && docker-php-ext-install intl opcache pdo_pgsql pgsql zip \
    && pecl install apcu pcov xdebug \
    && docker-php-ext-enable apcu pcov xdebug \
    && addgroup -g ${GROUP_ID} php \
    && adduser -h /home/php -s bin/sh -G php -D -u ${USER_ID} php \
    && echo "%php ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/php \
    && passwd -l root \
    && passwd -d root \
    && apk del --purge build-deps \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

WORKDIR /app

USER php

EXPOSE 9000

ADD ./entrypoint.sh /home/php/entrypoint.sh

ENTRYPOINT ["/home/php/entrypoint.sh"]

CMD ["php-fpm", "-F"]

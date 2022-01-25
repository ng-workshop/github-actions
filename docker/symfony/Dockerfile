FROM php:8.1-fpm-alpine

ARG GROUP_ID=1000
ARG USER_ID=1000

ENV APP_ENV dev
ENV COMPOSER_HOME /var/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_MEMORY_LIMIT -1

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ADD ./conf.d /usr/local/etc/php/conf.d
ADD ./entrypoint.sh /usr/local/bin/docker-symfony-entrypoint.sh

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
        jq \
        libzip \
        make \
        ncurses \
        openssh \
        postgresql-dev \
        shadow \
        sshpass \
        sudo \
        zlib \
    && docker-php-ext-install intl opcache pdo_pgsql pgsql zip \
    && pecl install apcu pcov xdebug \
    && docker-php-ext-enable apcu pcov xdebug \
    && addgroup -g ${GROUP_ID} symfony \
    && adduser -h /home/symfony -s bin/sh -G symfony -D -u ${USER_ID} symfony \
    && echo "%symfony ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers.d/symfony \
    && passwd -l root \
    && passwd -d root \
    && chmod a+x /usr/local/bin/docker-symfony-entrypoint.sh \
    && chown symfony:symfony /usr/local/bin/docker-symfony-entrypoint.sh \
    && apk del --purge build-deps \
    && rm -rf /var/cache/apk/* \
    && rm -rf /tmp/*

WORKDIR /var/www/symfony

USER symfony

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/docker-symfony-entrypoint.sh"]

CMD ["sh", "-c", "make install && php-fpm", "-F"]

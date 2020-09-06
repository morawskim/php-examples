FROM php:7.4-cli
SHELL ["/bin/bash", "-o", "pipefail", "-c"]
ARG WITH_XDEBUG=false

RUN docker-php-ext-install \
    pdo_mysql

RUN if [[ $WITH_XDEBUG = "true" ]]; then \
    pecl install xdebug-2.8.1 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  fi

USER nobody

FROM php:7.4-cli

ARG WITH_XDEBUG=false
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        librdkafka-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install rdkafka-4.0.3 && \
    docker-php-ext-enable rdkafka && \
    echo "extension=rdkafka.so" | tee /usr/local/etc/php/conf.d/rdkafka.ini

RUN if [[ $WITH_XDEBUG = "true" ]]; then \
    pecl install xdebug-2.7.0 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  fi

USER nobody

FROM php:7.2-cli

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        libpq-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo_pgsql pdo_mysql

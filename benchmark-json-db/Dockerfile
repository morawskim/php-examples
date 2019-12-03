FROM php:7.2-cli

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        unzip \
        libssl-dev \
        libpq-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo_pgsql pdo_mysql \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN curl -sS https://getcomposer.org/installer | php -- \
         --filename=composer \
         --install-dir=/usr/local/bin

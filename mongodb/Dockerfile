FROM php:8.2-cli

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        # these packages are required to build mongodb extension with support for SS: and crypto \
        # otherwise in output of phpinfo you would see \
        # with support  libmongoc SSL => disabled \
        # libmongoc crypto => disabled \
        libcurl4-openssl-dev pkg-config libssl-dev \
        # for composer \
        unzip \
        git && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb


RUN curl -sS https://getcomposer.org/installer | php -- \
         --filename=composer \
         --install-dir=/usr/local/bin

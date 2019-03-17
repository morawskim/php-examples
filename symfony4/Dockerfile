FROM phpstorm/php-71-apache-xdebug-27

# Install system packages
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && \
    apt-get -y install \
            vim \
            git \
            zip \
            unzip \
            libicu-dev \
            libz-dev \
            libmemcached-dev \
            telnet \
            openssh-client \
        --no-install-recommends && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN rm -rf /var/www/html && ln -s /app/public /var/www/html || true
RUN a2enmod rewrite headers
RUN docker-php-ext-install \
        intl \
        zip

RUN pecl install memcached
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin

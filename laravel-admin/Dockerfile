# hadolint ignore=DL3006
FROM php:7.2-apache

# Install system packages
ENV DEBIAN_FRONTEND=noninteractive
SHELL ["/bin/bash", "-o", "pipefail", "-c"]

# xdebug
RUN pecl install xdebug-2.7.0
RUN docker-php-ext-enable xdebug
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin

# apache
RUN a2enmod rewrite
# hadolint ignore=SC2015
RUN rm -rf /var/www/html && ln -s /app/public/ /var/www/html || true
RUN chown -R www-data:www-data /app/storage

# hadolint ignore=DL3008
RUN apt-get update && \
    apt-get -y install \
            vim \
            git \
            zip \
            unzip \
            libpq-dev \
        --no-install-recommends && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# Install the PHP pdo_pgsql extention
RUN docker-php-ext-install pdo_pgsql



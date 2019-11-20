FROM php:7.2-cli

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        libgpgme11-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install the PHP gnupg extention
RUN pecl install gnupg && echo "extension=gnupg.so" > /usr/local/etc/php/conf.d/gpg.ini



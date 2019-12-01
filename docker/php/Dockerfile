FROM php:7.3-fpm

WORKDIR /opt/pastry_shop

# Install extensions
RUN apt-get update && apt-get install -y \
        git \
        build-essential

# Install Docker PHP extensions
RUN docker-php-ext-install pdo_mysql

# Install Docker X-Debug tools
RUN pecl install xdebug
COPY ./files/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

FROM php:8.1-buster

RUN apt-get update && apt-get install -y \
    libmcrypt-dev \
    libicu-dev \
    libxslt-dev \
    libzip-dev \
    libwebp-dev \
    libxpm-dev \
    git

RUN docker-php-ext-install -j$(nproc) iconv zip bcmath xsl sockets
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
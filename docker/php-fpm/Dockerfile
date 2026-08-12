FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev libpng-dev libjpeg-dev libwebp-dev \
    libfreetype6-dev libonig-dev libxml2-dev libpq-dev git unzip procps \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) intl pdo_mysql pdo_pgsql zip gd opcache mbstring

COPY ./docker/php-fpm/usr/local/etc/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/php-fpm/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html
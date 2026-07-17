FROM php:8.4-fpm-alpine

RUN apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev \
    libxml2-dev

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]

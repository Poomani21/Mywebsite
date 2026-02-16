FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libonig-dev libssl-dev pkg-config \
    autoconf g++ make

# Install PHP extensions
RUN docker-php-ext-install zip mbstring

# Install MongoDB PHP extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Verify MongoDB loaded
RUN php -m | grep mongodb

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel cache + migrate + seed
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache \
 && php artisan migrate --force || true \
 && php artisan db:seed --force || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000

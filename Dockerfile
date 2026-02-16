FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libonig-dev libssl-dev pkg-config \
    autoconf g++ make

RUN docker-php-ext-install zip mbstring

# ✅ Install compatible MongoDB extension version
RUN pecl install mongodb-1.21.3 \
    && docker-php-ext-enable mongodb

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache \
 && php artisan migrate --force || true \
 && php artisan db:seed --force || true

EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=10000

FROM php:8.2-cli

# System deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip libssl-dev pkg-config \
    autoconf g++ make

# PHP extensions
RUN docker-php-ext-install zip mbstring curl

# Mongo extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Install Laravel deps WITHOUT scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

EXPOSE 10000

CMD php artisan key:generate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force || true && \
    php artisan db:seed --force || true && \
    php artisan serve --host=0.0.0.0 --port=10000

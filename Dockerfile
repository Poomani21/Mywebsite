FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip \
    libzip-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install zip mbstring curl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN cp .env.example .env || true

RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-req=ext-mongodb

EXPOSE 10000

CMD php artisan key:generate --force \
 && php artisan config:clear \
 && php artisan config:cache \
 && php artisan migrate --force || true \
 && php artisan db:seed --force || true \
 && php artisan serve --host=0.0.0.0 --port=10000

FROM php:8.2-cli

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libonig-dev \
    && docker-php-ext-install zip mbstring curl \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Create .env if not exists (IMPORTANT)
RUN cp .env.example .env || true

# Install Laravel deps (no scripts)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Generate key + cache
RUN php artisan key:generate --force \
 && php artisan config:clear \
 && php artisan config:cache || true

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000

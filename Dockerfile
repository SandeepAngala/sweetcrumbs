FROM php:8.2-fpm

# Set Composer environment variable
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libssl-dev \
    pkg-config \
    libzip-dev

# Clear apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install and enable MongoDB extension
RUN pecl install mongodb-1.21.5 && docker-php-ext-enable mongodb

# Verify MongoDB extension is installed
RUN php -m | grep mongodb

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . .

# Run composer install for non-interactive production build
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Clear old Laravel cache
RUN php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan route:clear || true \
    && php artisan view:clear || true

EXPOSE 9000
CMD ["php-fpm"]

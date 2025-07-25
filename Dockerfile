# Use PHP 8.2 FPM as base image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache \
    && pecl install redis && docker-php-ext-enable redis

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY . .

# Install PHP dependencies (skip scripts to avoid errors with dev dependencies)
RUN composer install --no-interaction --optimize-autoloader --no-scripts --no-dev

# Install Node.js dependencies and build assets
RUN npm install && \
    npm run build && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/build

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/build

# Generate application key if not exists
RUN if [ ! -f .env ]; then cp .env.example .env && php artisan key:generate; fi

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

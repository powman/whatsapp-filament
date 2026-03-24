# ──────────────────────────────────────────────
# Stage 1: Build frontend assets
# ──────────────────────────────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json* ./
RUN npm ci --no-audit

COPY vite.config.js ./
COPY resources ./resources

RUN npm run build

# ──────────────────────────────────────────────
# Stage 2: PHP application
# ──────────────────────────────────────────────
FROM php:8.2-fpm-alpine AS app

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    icu-dev \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        gd \
        intl \
        mbstring \
        pdo \
        pdo_mysql \
        zip \
        opcache \
        pcntl

# Install Redis extension
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del $PHPIZE_DEPS

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files and install dependencies (production only)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --optimize-autoloader

# Copy application source
COPY . .

# Copy built frontend assets from node-builder stage
COPY --from=node-builder /app/public/build ./public/build

# Complete composer install (run scripts, dump autoload)
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Copy PHP-FPM config
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini

# Entrypoint script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]

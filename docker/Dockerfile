FROM php:8.3-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y --no-install-recommends libicu-dev libzip-dev libxml2-dev libonig-dev zip unzip git && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl zip pdo pdo_mysql mbstring xml ctype fileinfo && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-interaction --no-progress

RUN chown -R www-data:www-data /app && chmod -R 775 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
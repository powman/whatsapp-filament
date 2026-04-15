FROM php:8.3-fpm

ARG USER_ID=1000
ARG GROUP_ID=1000

WORKDIR /app

RUN apt-get update && apt-get install -y --no-install-recommends libicu-dev libzip-dev libxml2-dev libonig-dev zip unzip git && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl zip pdo pdo_mysql mbstring xml ctype fileinfo && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Create user with matching UID/GID
RUN groupadd -g ${GROUP_ID} appuser && \
    useradd -u ${USER_ID} -g ${GROUP_ID} -m appuser

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN chown -R ${USER_ID}:${GROUP_ID} /app && chmod -R 775 storage bootstrap/cache

USER appuser

EXPOSE 9000
CMD ["php-fpm"]
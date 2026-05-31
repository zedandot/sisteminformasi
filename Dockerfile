FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring xml gd zip exif pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-scripts --ignore-platform-reqs

RUN npm install && npm run build

RUN cp .env.example .env && php artisan key:generate --force

RUN chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage

RUN chmod +x /var/www/html/docker/start.sh

CMD ["/bin/sh", "/var/www/html/docker/start.sh"]
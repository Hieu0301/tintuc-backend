FROM php:8.2-apache

# Cài extensions cần thiết
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tạo thư mục làm việc
WORKDIR /var/www/html

# Copy source
COPY . .

# Cài package
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Quyền cho Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Mở port
EXPOSE 80

# Apache run và migrate sau khi service sẵn sàng
CMD php artisan config:clear \
    && php artisan key:generate \
    && php artisan migrate --force \
    && apache2-foreground

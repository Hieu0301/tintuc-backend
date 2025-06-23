FROM php:8.2-apache

# Cài extension
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Đặt thư mục làm việc
WORKDIR /var/www/html

# Copy source Laravel vào container
COPY . .

# ⚠️ Quan trọng: Apache serve thư mục /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Chmod quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Cài package
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Mở port
EXPOSE 80

# Run migrate sau khi container chạy xong
CMD php artisan config:clear \
    && php artisan key:generate \
    && php artisan migrate --force \
    && apache2-foreground

FROM php:8.2-apache

# Cài các extension cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Cài Composer (quản lý package Laravel)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy toàn bộ mã nguồn Laravel vào container
COPY . /var/www/html

# Làm thư mục Laravel có quyền đúng để Apache sử dụng
WORKDIR /var/www/html
RUN composer install
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Mở port cho Apache
EXPOSE 80

# Chạy Apache server
CMD ["apache2-foreground"]

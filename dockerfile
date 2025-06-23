FROM php:8.2-apache

# Cài các extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Bật mod_rewrite cho Apache (Laravel yêu cầu)
RUN a2enmod rewrite

# Cài Composer (lấy từ image composer chính thức)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www/html

# Copy toàn bộ source Laravel vào container
COPY . .

# ⚠️ Đặt DocumentRoot về public (Laravel dùng thư mục public làm entry point)
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Đảm bảo quyền đúng để Apache có thể đọc
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Cài đặt PHP packages bằng Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Mở port HTTP
EXPOSE 80

# Chạy các lệnh Laravel khi container khởi động
CMD php artisan config:clear \
    && php artisan key:generate \
    && php artisan migrate --force \
    && apache2-foreground

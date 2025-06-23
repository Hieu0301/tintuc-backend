FROM php:8.2-apache

# Cài extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Bật mod_rewrite cho Laravel
RUN a2enmod rewrite

# Railway sẽ cấp biến môi trường PORT, mặc định mình gán là 8080
ENV PORT=8080

# Cấu hình Apache sử dụng PORT đúng
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf && \
    sed -i "s|<VirtualHost *:80>|<VirtualHost *:${PORT}>|" /etc/apache2/sites-available/000-default.conf && \
    sed -i "s|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|" /etc/apache2/sites-available/000-default.conf && \
    echo '<Directory "/var/www/html/public">\n    AllowOverride All\n</Directory>' >> /etc/apache2/apache2.conf

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy source code
WORKDIR /var/www/html
COPY . .

# Cấp quyền
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Cài các package PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Mở cổng
EXPOSE ${PORT}

# Lệnh khi container start
CMD php artisan config:clear && \
    php artisan key:generate && \
    php artisan migrate --force || true && \
    apache2-foreground

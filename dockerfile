FROM php:8.2-apache

# Cài extension
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Bật mod_rewrite
RUN a2enmod rewrite

# Apache lắng nghe PORT 8080
ENV PORT=8080
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory "/var/www/html/public">\n\tAllowOverride All\n</Directory>' >> /etc/apache2/apache2.conf

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy mã nguồn
WORKDIR /var/www/html
COPY . .

# Quyền
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Cài packages
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Port expose
EXPOSE 8080

# CMD chạy Laravel và Apache
CMD php artisan config:clear \
    && php artisan key:generate \
    && php artisan migrate --force || true \
    && apache2-foreground

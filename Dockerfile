# Sử dụng hình ảnh PHP với Apache
FROM php:8.1-apache

# Cài đặt các extension PHP cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd

# Kích hoạt mod_rewrite để hỗ trợ .htaccess và URL đẹp
RUN a2enmod rewrite

# Sao chép mã nguồn vào thư mục gốc của Apache
WORKDIR /var/www/html
COPY . /var/www/html

# Đảm bảo quyền truy cập
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Cấu hình Apache để cho phép sử dụng .htaccess
RUN echo '<Directory /var/www/html>
    AllowOverride All
    Require all granted
</Directory>' > /etc/apache2/conf-available/allow-override.conf \
    && a2enconf allow-override

# Expose cổng mặc định của Apache
EXPOSE 80

# Khởi động Apache
CMD ["apache2-foreground"]

FROM php:8.1-apache

# Cài đặt các extension cần thiết cho PHP
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd

# Thêm chỉ thị ServerName vào cấu hình Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
# Sao chép mã nguồn PHP
WORKDIR /var/www/html
COPY . /var/www/html
COPY icon.png /var/www/html/

# Đảm bảo quyền truy cập
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
RUN echo "DirectoryIndex index.php" > /etc/apache2/conf-available/directory-index.conf \
    && a2enconf directory-index
# Mở cổng 80 (Apache)
EXPOSE 80

# Lệnh khởi chạy Apache
CMD ["apache2-foreground"]

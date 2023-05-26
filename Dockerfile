# Menggunakan image PHP 8.1 sebagai base
FROM php:8.1-apache

# Set working directory ke direktori proyek Laravel
WORKDIR /var/www/html

# Install dependensi yang diperlukan oleh Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip

# Menggunakan Composer versi terbaru untuk menginstal dependensi Laravel
COPY composer.lock composer.json /var/www/html/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --ignore-platform-reqs

# Install ekstensi PHP yang diperlukan oleh Laravel
RUN docker-php-ext-install pdo_mysql zip

# Copy seluruh kode proyek ke dalam kontainer
COPY . /var/www/html

# Set permission agar Laravel dapat menulis ke direktori storage
RUN chown -R www-data:www-data /var/www/html/storage

# Tambahkan konfigurasi untuk menghubungkan ke MySQL container
ENV DB_HOST=mysql-container
ENV DB_PORT=3306
ENV DB_DATABASE=db_raport
ENV DB_USERNAME=root
ENV DB_PASSWORD=''

# Eksekusi perintah Laravel seperti migrasi atau pengaturan lainnya
RUN php artisan migrate --force

# Expose port 80 untuk HTTP
EXPOSE 80

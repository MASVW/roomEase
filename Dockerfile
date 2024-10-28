# Tahap 1: Membangun aset frontend dengan Node.js dan Vite
FROM node:18 AS node_builder

# Setel direktori kerja
WORKDIR /app

# Salin file package
COPY package.json yarn.lock ./

# Install dependensi Node.js
RUN yarn install --frozen-lockfile

# Salin semua kode aplikasi
COPY . .

# Bangun aset frontend
RUN yarn build

# Tahap 2: Install dependensi PHP dan siapkan aplikasi
FROM php:8.2-fpm-alpine AS php_builder

# Install dependensi sistem
RUN apk add --no-cache \
    bash \
    git \
    curl \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    autoconf \
    build-base

# Install ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Setel direktori kerja
WORKDIR /var/www/html

# Salin file composer
COPY composer.json composer.lock ./

# Install dependensi PHP dengan Composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Salin kode aplikasi
COPY . .

# Salin aset yang dibangun dari node_builder
COPY --from=node_builder /app/public/build ./public/build

# Atur izin
RUN chown -R www-data:www-data storage bootstrap/cache

# Tahap 3: Membuat image produksi dengan Apache
FROM php:8.2-apache

# Salin konfigurasi PHP dari php_builder
COPY --from=php_builder /usr/local/etc/php/ /usr/local/etc/php/
COPY --from=php_builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=php_builder /usr/local/bin/php /usr/local/bin/php
COPY --from=php_builder /usr/local/bin/composer /usr/local/bin/composer

# Aktifkan modul Apache
RUN a2enmod rewrite

# Setel direktori kerja
WORKDIR /var/www/html

# Salin kode aplikasi
COPY --from=php_builder /var/www/html ./

# Atur izin
RUN chown -R www-data:www-data storage bootstrap/cache

# Salin konfigurasi Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Ekspos port 8080 untuk Cloud Run
EXPOSE 8080

# Jalankan Apache
CMD ["apache2-foreground"]

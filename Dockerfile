FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    zip \
    curl \
    git \
    gnupg \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip intl

# Enable mod_rewrite
RUN a2enmod rewrite

ENV PORT=8080
ENV SERVER_NAME=roomease-819813528864.asia-southeast2.run.app
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf && \
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf && \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf && \
    echo "ServerName ${SERVER_NAME}" >> /etc/apache2/apache2.conf

# Copy the application code
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies using Composer
RUN composer install

RUN php -r "file_exists('.env') || copy('.env.production', '.env');"

# Install Node.js dependencies using npm
RUN npm ci && npm run build

RUN mv /var/www/html/public/build/.vite/manifest.json /var/www/html/public/build/manifest.json

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN find storage -type d -exec chmod 777 {} \; && \
    find public/storage -type d -exec chmod 777 {} \;

RUN php artisan storage:link && \
    ln -s /var/www/html/public/build /var/www/html/build
# 12. Optimasi konfigurasi Laravel
RUN php -d memory_limit=-1 artisan key:generate --ansi --force && \
    php -d memory_limit=-1 artisan config:cache && \
    php -d memory_limit=-1 artisan route:cache && \
    php -d memory_limit=-1 artisan view:cache && \
    php -d memory_limit=-1 artisan optimize

# 13. Expose port untuk Cloud Run
EXPOSE ${PORT}

# 14. Copy dan beri izin pada entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# 15. Jalankan aplikasi dengan entrypoint, for seeding
#ENTRYPOINT ["/entrypoint.sh"]

CMD ["apache2-foreground"]

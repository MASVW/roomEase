FROM php:8.2-apache

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    libicu-dev \
    zip \
    curl \
    git \
    gnupg

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip intl

# Enable mod_rewrite
RUN a2enmod rewrite

ENV PORT 8080

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
RUN sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Install Node.js and npm (needed for Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Copy the application code
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install project dependencies using Composer
RUN composer install

# Install Node.js dependencies using npm
RUN npm install

# Build assets using Vite
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose the port
EXPOSE 8080

CMD ["apache2-foreground"]

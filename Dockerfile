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
ENV SERVER_NAME roomease-819813528864.asia-southeast2.run.appasdjn

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
RUN sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf
RUN echo "ServerName ${SERVER_NAME}" >> /etc/apache2/apache2.conf

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

COPY startup-script.sh /startup-script.sh
RUN chmod +x /startup-script.sh

# Expose the port
EXPOSE 8080

CMD ["apache2-foreground"]

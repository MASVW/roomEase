FROM php:8.2-apache

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    libicu-dev \
    zip \
    curl \
    git \
    gnupg \
    && rm -rf /var/lib/apt/lists/* # Clear cache to reduce image size

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip intl

# Enable mod_rewrite
RUN a2enmod rewrite

ENV PORT 8080
ENV SERVER_NAME roomease-819813528864.asia-southeast2.run.app
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
RUN sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf


RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf
RUN echo "ServerName ${SERVER_NAME}" >> /etc/apache2/apache2.conf

# Install Node.js and npm (needed for Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get update && apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY package.json package-lock.json ./
RUN npm install

COPY . .

RUN composer dump-autoload --optimize

# Build assets using Vite
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy and set up startup script
COPY startup-script.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/startup-script.sh

# Expose the port
EXPOSE ${PORT}

# Use the startup script as entrypoint
ENTRYPOINT ["/usr/local/bin/startup-script.sh"]

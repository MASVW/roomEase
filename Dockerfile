ARG PHP_VERSION=8.2-apache
FROM php:${PHP_VERSION} as php_laravel

# install dependencies for laravel 8
RUN apt-get update && apt-get install -y \
  curl \
  git \
  libicu-dev \
  libpq-dev \
  openssl \
  unzip \
  vim \
  zip \
  zlib1g-dev \
  libpng-dev \
  libzip-dev && \
rm -r /var/lib/apt/lists/*

# install extension for laravel 8
RUN docker-php-ext-install fileinfo exif pcntl bcmath gd pdo pdo_mysql && \
  a2enmod rewrite

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

FROM php_laravel as executeable

ENV APP_SOURCE /var/www/php
ENV APP_DEBUG false
ENV APP_URL ""
ENV APP_ENV=production

# Set working directory
WORKDIR $APP_SOURCE

# set DocumentRoot to lavavel framework uploaded
RUN sed -i "s|DocumentRoot /var/www/html|DocumentRoot ${APP_SOURCE}/public|g" /etc/apache2/sites-enabled/000-default.conf

# copy source laravel
COPY . .

# install dependency laravel
RUN php -r "file_exists('.env') || copy('.env.example', '.env');" && \
    composer install --no-interaction --optimize-autoloader --no-dev && \
    php artisan package:discover --ansi && \
    php artisan key:generate --ansi --force && \
    php artisan optimize

VOLUME ${APP_SOURCE}/storage

# expose port default 80
EXPOSE 80/tcp

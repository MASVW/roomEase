#!/bin/bash

# Check if we have mounted secrets at the specific path
if [ -f "/config/uph-room-ease-config" ]; then
    # Copy the mounted secret to .env
    cp /config/uph-room-ease-config /var/www/html/.env

    # Set proper permissions
    chown www-data:www-data /var/www/html/.env
    chmod 640 /var/www/html/.env
fi

# Generate application key if not set
php artisan key:generate --no-interaction --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in foreground
exec apache2-foreground

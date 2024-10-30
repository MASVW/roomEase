#!/bin/bash
set -e  # Exit on error

# Check if we have mounted secrets
if [ -d "/config" ]; then
    echo "Copying environment file from secrets..."
    cp /config/.env /var/www/html/.env

    # Set proper permissions
    chown www-data:www-data /var/www/html/.env
    chmod 640 /var/www/html/.env
else
    echo "Warning: /config directory not found. Make sure secrets are mounted correctly."
    exit 1
fi

# Wait for the .env file to be available
MAX_RETRIES=30
RETRY_COUNT=0
while [ ! -f /var/www/html/.env ] && [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
    echo "Waiting for .env file to be available..."
    sleep 1
    RETRY_COUNT=$((RETRY_COUNT + 1))
done

if [ ! -f /var/www/html/.env ]; then
    echo "Error: .env file not found after waiting. Exiting."
    exit 1
fi

echo "Setting up Laravel application..."

# Clear previous cache
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Generate application key if not set
if [ -z "$(grep '^APP_KEY=' .env)" ] || [ "$(grep '^APP_KEY=' .env | cut -d '=' -f 2)" == "" ]; then
    echo "Generating application key..."
    php artisan key:generate --no-interaction --force
fi

# Optimize application
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Apache..."
exec apache2-foreground

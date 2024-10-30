#!/bin/bash
set -e  # Exit on error

# Define the exact config paths based on your Cloud Run configuration
CONFIG_FILE="/config/uph-room-ease-config"

echo "Starting initialization..."
echo "Checking for configuration file..."

# Check if we have mounted secrets
if [ -f "$CONFIG_FILE" ]; then
    echo "Found configuration file at $CONFIG_FILE"
    echo "Copying environment file to Laravel .env..."

    # Copy the mounted secret to Laravel's .env
    cp "$CONFIG_FILE" /var/www/html/.env

    # Set proper permissions
    chown www-data:www-data /var/www/html/.env
    chmod 640 /var/www/html/.env

    echo "Environment file copied successfully"
else
    echo "Error: Configuration file not found at $CONFIG_FILE"
    echo "Current contents of /config directory:"
    ls -la /config || echo "Could not list /config directory"
    exit 1
fi

# Verify the .env file exists and is readable
if [ ! -f /var/www/html/.env ]; then
    echo "Error: .env file was not created successfully"
    exit 1
fi

echo "Setting up Laravel application..."

# Clear previous cache
echo "Clearing existing cache..."
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

echo "Initialization complete. Starting Apache..."
exec apache2-foreground

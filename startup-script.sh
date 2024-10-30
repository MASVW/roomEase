echo "[ENV CHECK] Starting environment setup..."

# Log the contents of /config directory
echo "[ENV CHECK] Contents of /config directory:"
ls -la /config

# Check for config file
if [ -f "/config/uph-room-ease-config" ]; then
    echo "[ENV CHECK] Found config file at /config/uph-room-ease-config"

    # Copy file with verbose
    echo "[ENV CHECK] Copying config to .env..."
    cp -v /config/uph-room-ease-config /var/www/html/.env

    # Verify copy
    if [ -f "/var/www/html/.env" ]; then
        echo "[ENV CHECK] .env file exists after copy"
        echo "[ENV CHECK] .env file size: $(stat -c%s /var/www/html/.env) bytes"
        echo "[ENV CHECK] First line of .env (showing only variable name):"
        head -n 1 /var/www/html/.env | cut -d= -f1
    else
        echo "[ENV CHECK] ERROR: .env file not created!"
    fi
else
    echo "[ENV CHECK] ERROR: Config file not found!"
fi

# Set permissions
chown www-data:www-data /var/www/html/.env
chmod 640 /var/www/html/.env

# Continue with Laravel setup
php artisan key:generate --no-interaction --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground

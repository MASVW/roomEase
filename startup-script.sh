#!/bin/bash
# Exit on any error
set -e

# Load the Secret Manager secret into an environment variable
SECRET_NAME="uph-room-ease-config"
gcloud secrets versions access latest --secret="${SECRET_NAME}" --format='get(payload.data)' | tr '_-' '/+' | base64 -d > /var/www/html/.env

# Set file permissions for the .env file
chown www-data:www-data /var/www/html/.env

# Execute the main command (CMD in Dockerfile)
exec "$@"

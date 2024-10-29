#!/bin/bash
echo "Script started."
SECRET_NAME="nama_secret_env_anda"
echo "Fetching secret named ${SECRET_NAME}."

gcloud secrets versions access latest --secret="${SECRET_NAME}" --format='get(payload.data)' | tr '_-' '/+' | base64 -d > /var/www/html/.env
result=$?
if [ $result -ne 0 ]; then
    echo "Failed to fetch the secret."
    exit $result
else
    echo "Secret successfully fetched and written to /var/www/html/.env."
fi

chown www-data:www-data /var/www/html/.env
echo "Permissions set for .env file."

# Debug: Display the content of .env to ensure it's correct
cat /var/www/html/.env

exec "$@"

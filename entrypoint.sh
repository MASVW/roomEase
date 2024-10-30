#!/bin/sh

# Pindah ke direktori aplikasi Laravel
cd /var/www/html

# Debug: Pastikan file dan direktori terlihat
ls -la

# Jalankan migrasi dan seeding
php artisan migrate --force --seed

# Jalankan Apache di foreground agar container tetap aktif
exec apache2-foreground

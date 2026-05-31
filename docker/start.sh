#!/bin/sh

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Start queue worker in background (untuk sinkronisasi Google Calendar, dll)
php artisan queue:work --daemon --tries=3 &

# Start web server
php -S 0.0.0.0:${PORT:-8080} -t public

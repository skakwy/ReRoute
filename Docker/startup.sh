#!/bin/bash
touch /safeData/laravel.db
chmod 666 /safeData/laravel.db
chown -R www-data:www-data /safeData
cd /safeData/ssl/ && openssl genrsa -out laravel.key 2048
openssl req -new -key laravel.key -out laravel.csr -subj "/C=DE/ST=Some-State/CN=localhost/"
openssl x509 -req -days 365 -in laravel.csr -signkey laravel.key -out laravel.crt
cd /var/www/html/ReRoute
composer install
#npm install
php artisan migrate:fresh
chmod 666 /app/docker.sock
#nohup npm run dev >/dev/null 2>&1 &
apache2-foreground

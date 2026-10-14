#!/bin/sh
set -e

mkdir -p /data
touch /data/database.sqlite

php artisan migrate --force
php artisan optimize

exec /start-container.sh
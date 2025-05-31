#!/bin/bash

until mysqladmin ping -h db --silent; do
  echo "Waiting for database connection..."
  sleep 5
done

if [ ! -f /var/www/.migrated ]; then
  php artisan migrate:fresh --force --seed
  touch /var/www/.migrated
  php artisan storage:link
fi

php artisan optimize
php artisan config:cache

exec "$@"
#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

service memcached start

cp -rf /usr/src/blog /var/www/ && rm -rf /usr/src/*
find /var/www -type d -exec chmod 755 {} \;
find /var/www -type f -exec chmod 644 {} \;
chmod -R 777 /var/www/blog/storage
chmod -R 777 /var/www/blog/bootstrap/cache
cd /var/www/blog && rm -f .env
echo Rename env
mv -f .env.production .env
echo Run migrations
php artisan migrate --force
echo Install composer
composer install
#echo Clear cache
#sphp artisan ca:cl
chown -R www-data:www-data /var/www
touch /var/www/blog/up

exec "$@"

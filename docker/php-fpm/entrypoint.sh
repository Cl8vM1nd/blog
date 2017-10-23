#!/bin/sh
set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

if [ ! -f /var/www/blog/index.php ]; then
	cp -rf /usr/src/blog /var/www/ && rm -rf /usr/src/
	find /var/www -type d -exec chmod 755 {} \;
	find /var/www -type f -exec chmod 644 {} \;
	chmod -R 777 /var/www/blog/storage
	chmod -R 777 /var/www/blog/bootstrap/cache
	cd /var/www/blog && composer install
	mv -f /var/www/blog/.env.production /var/www/blog/.env
	php artisan migrate --force
	chown -R www-data:www-data /var/www
fi

exec "$@"

#!/bin/bash

export BASE_DIR=$(cd "$(dirname "$0")"; pwd)
sPath="$BASE_DIR/dev/services"

docker-compose \
  -f "$sPath/networks.yml" \
  -f "$sPath/mysql.yml" \
  -f "$sPath/redis.yml" \
  -f "$sPath/web.yml" \
  up -d

cp website/.env.production website/.env
echo '1.Artisan'
docker exec -it blog php artisan migrate
echo '2.Composer'
docker exec -it blog composer install
#echo '3.Bower'
#docker exec -it blog bower update --allow-root
echo '3.Chown'
docker exec -it blog chown -R www-data:www-data /var/www
echo '4.Chmod'
docker exec -it blog chmod -R 777 /var/www/blog/storage
docker exec -it blog chmod -R 777 /var/www/blog/bootstrap/cache

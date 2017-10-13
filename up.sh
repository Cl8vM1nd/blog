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
docker exec -it blog php artisan migrate
docker exec -it blog composer install
docker exec -it blog bower update --allow-root
docker exec -it blog chown -R www-data:www-data /var/www

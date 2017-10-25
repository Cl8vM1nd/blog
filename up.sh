#!/bin/bash

export BASE_DIR=$(cd "$(dirname "$0")"; pwd)

#Const
readonly PROD="PROD"
readonly DEV="DEV"
ENVIRONMENT=PROD

while [[ $# -gt 0 ]]
do
key="$1"

case $key in
    -e|--environment)
    ENVIRONMENT="$2"
    shift # past argument
    shift # past value
    ;;
    *)    # unknown option
    ENVIRONMENT=PROD # save it in an array for later
    shift # past argument
    ;;
esac
done

if [ "$ENVIRONMENT" == "$DEV" ]; then
    echo "RUNNING DEV"
    sPath="$BASE_DIR/dev/services"
    docker-compose \
      -f "$sPath/networks.yml" \
      -f "$sPath/mysql.yml" \
      -f "$sPath/redis.yml" \
      -f "$sPath/web.yml" \
      up --build -d
    echo "VISIT WEBSITE http://blog.me:777"
else
  echo "PROD"
  sPath="$BASE_DIR/prod/services"
  docker-compose \
    -f "$sPath/networks.yml" \
    -f "$sPath/mysql.yml" \
    -f "$sPath/redis.yml" \
    -f "$sPath/web.yml" \
    up --build -d
fi

#cp website/.env.production website/.env
#echo '1.Artisan'
#docker exec -it blog php artisan migrate
#echo '2.Composer'
#docker exec -it blog composer install
#echo '3.Bower'
#docker exec -it blog bower update --allow-root
#echo '3.Chown'
#docker exec -it blog chown -R www-data:www-data /var/www
#echo '4.Chmod'
#ocker exec -it blog chmod -R 777 /var/www/blog/storage
#docker exec -it blog chmod -R 777 /var/www/blog/bootstrap/cache

#!/bin/bash
export BASE_DIR=$(cd "$(dirname "$0")"; pwd)
sPath="$BASE_DIR/services"

docker-compose \
  -f "$sPath/networks.yml" \
  -f "$sPath/mysql.yml" \
  -f "$sPath/redis.yml" \
  -f "$sPath/web.yml" \
   down

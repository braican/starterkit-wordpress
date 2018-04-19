#!/bin/bash

set -e

fullpath=$1
filename="${fullpath##*/}"

echo "Importing database $1"
mv $1 db/
docker-compose exec wordpress wp db import /var/www/db/${filename}
echo "done"
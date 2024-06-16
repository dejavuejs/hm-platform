#!/bin/bash

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion

# just to be sure that no traces left
docker-compose down -v

# building and running docker-compose file
docker-compose build && docker-compose up -d

# container id by image name
apache_container_id=$(docker ps -aqf "name=platform-php-apache")
db_container_id=$(docker ps -aqf "name=platform-mysql")
worker_container_id=$(docker ps -aqf "name=platform-worker")

# checking connection
echo "Please wait... Waiting for MySQL connection..."
while ! docker exec ${db_container_id} mysql --user=root --password=omr -e "SELECT 1" >/dev/null 2>&1; do
    sleep 1
done

# creating empty database for platform
echo "Creating empty database for platform..."
while ! docker exec ${db_container_id} mysql --user=root --password=omr -e "CREATE DATABASE platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" >/dev/null 2>&1; do
    sleep 1
done

# creating empty database for platform testing
echo "Creating empty database for platform testing..."
while ! docker exec ${db_container_id} mysql --user=root --password=root -e "CREATE DATABASE platform_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" >/dev/null 2>&1; do
    sleep 1
done

docker exec -i ${apache_container_id} bash -c "cd /var/www/html && find storage/ -type d -exec chmod 777 {} \;"
docker exec -i ${apache_container_id} bash -c "cd /var/www/html && find storage/ -type f -exec chmod 666 {} \;"

# setting up platform
# echo "Now, setting up platform..."
# docker exec ${apache_container_id} git clone https://github.com/platform/platform

# # setting platform stable version
# echo "Now, setting up platform stable version..."
# docker exec -i ${apache_container_id} bash -c "cd platform && git reset --hard $(git describe --tags $(git rev-list --tags --max-count=1))"

# installing composer dependencies inside container
docker exec -i ${apache_container_id} bash -c "cd /var/www/html && composer install"

# moving `.env` file
docker cp .env.example ${apache_container_id}:/var/www/html/.env
# docker cp .configs/.env.testing ${apache_container_id}:/var/www/html/platform/.env.testing

# executing final commands
docker exec -i ${apache_container_id} bash -c "cd /var/www/html && php artisan optimize:clear && php artisan db:seed && php artisan migrate:fresh --seed && php artisan storage:link && php artisan vendor:publish --force && php artisan optimize:clear && php artisan horizon:install"
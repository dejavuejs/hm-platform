# Steps

1. clone git repo
2. copy `.env.example` to `.env` and edit it if needed
3. depend on serve method you can use docker-compose in case if you wand to run whole App with DataBase
    or run only App container

## docker-compose -- production
1. build docker images `docker-compose build`
2. run docker containers `docker-compose up -d --remove-orphans`
3. connect to container and `docker-compose exec app bash -c ./INSTALL.sh`
4. stop docker containers `docker-compose down`

## docker-compose --local
1. docker-compose -f docker-compose.local.yml build
2. docker-compose up -f docker-compose.local.yml -d --remove-orphans

To dump autoload
# docker-compose exec app bash -c './composer.phar dumpautoload'

## docker
1. build docker image `docker build -t bryg .`
2. run docker container
```sh
docker run -d --rm -p 80:80 \
   -v $(pwd)/:/var/www/html:cached \
   -v $(pwd)/apache2.conf:/etc/apache2/apache2.conf:ro \
   -v $(pwd)/php.ini:/usr/local/etc/php/php.ini:ro \
   --name=app bryg
```
3. connect to container and `docker exec app bash -c ./INSTALL.sh`
4. stop docker container `docker stop app`

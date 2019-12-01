#!/usr/bin/env bash

docker-compose down

docker run --rm --interactive --tty --user $(id -u):$(id -g) --volume $PWD:/app --volume /tmp:/tmp composer install
docker-compose up -d
echo 'Waiting for mysql'
sleep 30
docker-compose exec php-fpm php bin/console doctrine:migrations:migrate
docker-compose exec php-fpm php bin/console bts:gallery:import
docker-compose exec php-fpm php bin/console bts:gallery:photo:import

echo 'Now you can open http://localhost in your browser'
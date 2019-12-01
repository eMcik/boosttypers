#!/usr/bin/env bash

docker run --rm --interactive --tty --user $(id -u):$(id -g) --volume $PWD:/app --volume /tmp:/tmp composer install
docker-compose up -d
until nc -z -v -w30 localhost 3306
do
  echo "Waiting for database connection..."
  # wait for 5 seconds before check again
  sleep 5
done
docker-compose exec php-fpm php bin/console doctrine:migrations:migrate
docker-compose exec php-fpm php bin/console bts:gallery:import
docker-compose exec php-fpm php bin/console bts:gallery:photo:import

echo 'Now you can open http://localhost in your browser'
# BoostTypers Deers Gallery

## How to start

- run `docker-composer up -d`

- run `docker-compose exec php-fpm php bin/console doctrine:migrations:migrate`

- import galleries - run `docker-compose exec php-fpm php bin/console bts:gallery:import`
  
- import photos - run `docker-compose exec php-fpm php bin/console bts:gallery:photo:mport`

- open `http://localhost` in yours browser

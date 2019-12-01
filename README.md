# BoostTypers Deers Gallery

## How to start

### Install Docker
  
- On MacOSX: https://docs.docker.com/docker-for-mac/)

- On Linux: https://docs.docker.com/install/linux/docker-ce/ubuntu/

### Install Docker compose

- https://docs.docker.com/compose/install/

### Run commands

- run `docker run --rm --interactive --tty --user $(id -u):$(id -g) --volume $PWD:/app --volume /tmp:/tmp composer install`

- run `docker-compose up -d`

- run `docker-compose exec php-fpm php bin/console doctrine:migrations:migrate`

- import galleries - run `docker-compose exec php-fpm php bin/console bts:gallery:import`
  
- import photos - run `docker-compose exec php-fpm php bin/console bts:gallery:photo:import`

- or just run the script `./install.sh`

Open `http://localhost` in your browser

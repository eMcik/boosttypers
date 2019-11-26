FROM php:fpm-alpine

WORKDIR /var/www

RUN docker-php-ext-install pdo_mysql

CMD ["php-fpm"]

EXPOSE 9000
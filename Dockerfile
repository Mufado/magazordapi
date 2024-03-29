# Receive MySQL image
FROM mysql:8.2.0 as mysql

# Configure database enviromnent constraints
ENV MYSQL_DATABASE=magazordapi
ENV MYSQL_ROOT_PASSWORD=1234
ENV MYSQL_USER=maga
ENV MYSQL_PASSWORD=zord

# Configure database volume data
VOLUME ./db_data /var/lib/mysql

# Sets initial migration
COPY ./migration.sql /docker-entrypoint-initdb.d/
RUN chmod -R 775 /docker-entrypoint-initdb.d

# Receive php image
FROM php:8.3-apache

# Enable pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Activates superuser on Composer to the container
ENV COMPOSER_ALLOW_SUPERUSER=1

# Gets Composer from image
COPY --from=composer:2.6.5 /usr/bin/composer /usr/bin/composer

# Install Git so Composer can download dependencies
RUN apt-get -y update
RUN apt-get -y install git

#==============#
# Dependencies #
#==============#

# Change to composer.json location
WORKDIR /var/www/html/

# Twig: https://twig.symfony.com/
RUN composer require twig/twig:3.8.0

# Install Composer dependencies
RUN composer install --prefer-dist --no-dev --no-progress --no-interaction

# Copies app data
COPY app/ .

WORKDIR /

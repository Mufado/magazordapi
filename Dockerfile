# Receive MySQL image
FROM mysql:8.2.0

# Sets initial migration
ADD migration.sql /docker-entrypoint-initdb.d/migration.sql
RUN chmod -R 775 /docker-entrypoint-initdb.d

# Receive php image
FROM php:8.3-apache

# Enable pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Activates superuser on Composer to the container
ENV COMPOSER_ALLOW_SUPERUSER=1

# Gets Composer from image
COPY --from=composer:2.6.5 /usr/bin/composer /usr/bin/composer

# Default configuration to use Apache
COPY app/ /var/www/html/

# Install Git so Composer can download dependencies
RUN apt-get -y update
RUN apt-get -y install git

#==============#
# Dependencies #
#==============#
RUN composer require twig/twig:3.8.0

# Install Composer dependencies
RUN composer install --prefer-dist --no-dev --no-progress --no-interaction

FROM composer:2.5.4 AS composer
FROM php:8.2.4-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev git libzip-dev zip libpq-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev libicu-dev
RUN docker-php-ext-configure zip && docker-php-ext-install pgsql pdo_pgsql zip soap gd intl bcmath

COPY --from=composer /usr/bin/composer /usr/bin/composer

ARG PROJECT_NAME
WORKDIR /var/www/${PROJECT_NAME}

RUN useradd -m ${PROJECT_NAME} \
    && usermod -aG root ${PROJECT_NAME} \
    && chown -R ${PROJECT_NAME}:www-data ./ \
    && find ./ \( -path ./vendor -o -path ./node_modules \) -exec chmod 775 {} \;


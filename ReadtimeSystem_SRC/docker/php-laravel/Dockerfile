FROM php:7.4-fpm

ENV DEBCONF_NOWARNINGS yes
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y git libzip-dev zip unzip vim libpq-dev libonig-dev libxml2-dev
RUN set -ex apk --no-cache add postgresql-dev libpq-dev oniguruma-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_pgsql mbstring
# Node.js
RUN apt install -y nodejs npm
RUN npm install n -g
RUN n stable
RUN apt purge -y nodejs npm

# Webpack
RUN npm install webpack

# xDebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN composer global require hirak/prestissimo

RUN mkdir -p /var/www/s_leadtime
ADD . /var/www/s_leadtime/

WORKDIR /var/www/s_leadtime

RUN chmod -R a+w storage/ bootstrap/cache
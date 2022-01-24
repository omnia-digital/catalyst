# Serve everything with Apache
FROM php:8.0-apache

WORKDIR /srv/app

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get -y update \
    && apt-get install -y libicu-dev libpng-dev zlib1g-dev libzip-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN docker-php-ext-install pdo pdo_mysql intl gd \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && chown -R www-data:www-data /srv/app \
    && a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

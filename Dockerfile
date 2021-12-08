FROM php:7.2-apache

ADD www /var/www

RUN apt-get update -y && apt-get install -y imagemagick && chown -R www-data:www-data /var/www && chmod +x /var/www/crop
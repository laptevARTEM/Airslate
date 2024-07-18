FROM php:8-apache

ADD ./000-default.conf /etc/apache2/sites-available/000-default.conf

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN a2enmod rewrite

RUN service apache2 restart

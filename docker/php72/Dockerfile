FROM php:7.2-apache

RUN apt-get update && apt-get install -y git

RUN rm -rf /etc/apache2/sites-enabled/000-default.conf
COPY docker/php72/dev-009.conf /etc/apache2/sites-available/
COPY docker/php72/php.ini /usr/local/etc/php/

RUN a2enmod rewrite && service apache2 restart && a2ensite dev-009.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# github-token user https://github.com/mihailaz
RUN composer config -g github-oauth.github.com cb6bb1cd4ba2449ffa9c874c6ba9d361b01fb1d1

WORKDIR /var/www/dev-009

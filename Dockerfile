FROM php:8.2-apache

RUN apt-get update

RUN apt-get install -y libpng-dev

RUN apt-get install -y libjpeg62-turbo-dev

RUN apt-get install -y libfreetype6-dev

RUN apt-get install -y libzip-dev

RUN apt-get install -y libonig-dev

RUN apt-get install -y libxml2-dev

RUN apt-get install -y zip unzip git curl

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install pdo pdo_mysql mbstring tokenizer xml ctype fileinfo zip opcache gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && a2enmod rewrite

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache && chmod -R 777 storage bootstrap/cache && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
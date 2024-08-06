FROM php:8.3-apache

# Install necessary PHP extensions and other dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip mysqli pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite
RUN a2ensite 000-default

WORKDIR /var/www/html

# RUN composer install
# RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
# apt-get install -y nodejs

EXPOSE 80
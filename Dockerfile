# Use the official PHP image with Apache
FROM php:8.3-apache

# Install necessary PHP extensions and other dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && docker-php-ext-install zip mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Apache configuration file
COPY config/docker.conf /etc/apache2/sites-available/000-default.conf

# Enable the site
RUN a2ensite 000-default

# Set working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80
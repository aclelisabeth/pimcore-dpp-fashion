FROM php:8.1-apache

# Install minimal dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Enable Apache rewrite
RUN a2enmod rewrite

# Set document root
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf

WORKDIR /var/www/html

CMD ["apache2-foreground"]

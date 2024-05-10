# Use the official PHP 8.1 image with Apache
FROM php:8.1-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Install required dependencies
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip \
    libonig-dev \
    libgd-dev \
    && docker-php-ext-install zip pdo_mysql mbstring gd

# Enable Apache modules
RUN a2enmod rewrite

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application code
COPY . /var/www/html

# Install composer dependencies
RUN composer install --no-scripts --no-autoloader

# Generate the autoload files and optimize
RUN composer dump-autoload --optimize

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set up Laravel application
RUN cp .env.example .env
RUN php artisan key:generate

# Expose port 80
EXPOSE 8085

# Start Apache
CMD ["apache2-foreground"]

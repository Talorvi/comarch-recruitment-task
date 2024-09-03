# Use the official PHP image from Docker Hub
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Install Composer globally
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Copy the contents of the src/ directory to the /var/www/html/src directory in the container
COPY project/src/ /var/www/html/src/

# Set the document root to the src directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/src

# Update the Apache configuration to use the new document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set working directory
WORKDIR /var/www/html/src/

# Ensure the Apache server can write to the /var/www/html/src directory
RUN chown -R www-data:www-data /var/www/html/src

# Enable Apache mod_rewrite if needed
RUN a2enmod rewrite

# Expose port 80 for the web server
EXPOSE 80

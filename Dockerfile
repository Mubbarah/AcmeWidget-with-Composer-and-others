# Use the official PHP 8.1 image
FROM php:8.1-cli

# Set the working directory
WORKDIR /app

# Copy application files into the container
COPY . .

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php && \
    mv composer.phar /usr/local/bin/composer

# Install PHP dependencies
RUN composer install

# Expose the default PHP development server port
EXPOSE 8000

# Start the PHP built-in server
CMD ["php", "-S", "0.0.0.0:8000"]

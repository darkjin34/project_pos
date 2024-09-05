FROM php:8.2-fpm

WORKDIR /var/www/html

# Install necessary PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install GD and ZIP extensions with necessary dependencies
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip

# Set ownership and permissions
RUN chown -R www-data:www-data /var/www

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create a new user
RUN adduser --disabled-password --gecos '' developer

# Add user to the group
RUN chown -R developer:www-data /var/www

RUN chmod 755 /var/www

# Switch to this user
USER developer

# Expose port 5173 (for Vite or development server)
EXPOSE 5173
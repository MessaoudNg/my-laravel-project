FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    curl

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy app files
COPY . /var/www/html
WORKDIR /var/www/html

# Composer install
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Nginx config
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Start both Nginx and PHP-FPM
CMD php-fpm & nginx -g 'daemon off;'

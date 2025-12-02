# ----------------------------------------------------
# PHP-FPM 8.3 + Extensions (Solution for Render)
# ----------------------------------------------------
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    nginx

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Copy project
COPY . /var/www/html

WORKDIR /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Composer install
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Copy nginx config
COPY nginx.conf /etc/nginx/sites-enabled/default

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80
CMD service nginx start && php-fpm

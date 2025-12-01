# -----------------------------
# 1) PHP 8.1 + Extensions
# -----------------------------
FROM php:8.0-fpm


# تثبيت الحزم الأساسية
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    nginx \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip xml gd

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -----------------------------
# 2) Laravel Setup
# -----------------------------
WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# إنشاء env لو غير موجود
RUN cp .env.example .env || true

RUN php artisan key:generate || true

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# -----------------------------
# 3) إعداد NGINX
# -----------------------------
COPY ./nginx.conf /etc/nginx/sites-enabled/default

# فتح المنفذ
EXPOSE 80

# -----------------------------
# 4) Start Script
# -----------------------------
CMD service nginx start && php-fpm

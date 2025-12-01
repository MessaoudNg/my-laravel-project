# الصورة الأساسية PHP بصيغة FPM
FROM php:8.1-fpm

# تثبيت الأدوات اللازمة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# تثبيت إضافات PHP المطلوبة للـ Laravel
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# تثبيت Composer داخل الحاوية
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# مجلد العمل داخل الحاوية
WORKDIR /var/www/html

# نسخ المشروع كاملًا
COPY . .

# تثبيت اعتمادات Laravel بدون أي سكريبتات
RUN composer install --no-dev --no-scripts --prefer-dist --no-progress --no-interaction

# توليد APP_KEY بعد تثبيت الـ vendor
RUN php artisan key:generate || true

# أعطاء صلاحيات للمجلدات الضرورية
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# المنفذ
EXPOSE 9000

# تشغيل PHP-FPM بشكل افتراضي
CMD ["php-fpm"]

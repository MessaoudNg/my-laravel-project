# استخدم صورة PHP مع امتدادات Laravel المطلوبة
FROM php:8.1-fpm

# تثبيت الأدوات المطلوبة
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl

# تمكين امتدادات PHP
RUN docker-php-ext-install pdo_mysql zip

# نسخ Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع
COPY . /var/www/html

# ضبط مجلد العمل
WORKDIR /var/www/html

# تثبيت اعتمادات المشروع
RUN composer install --optimize-autoloader --no-dev

# ضبط صلاحيات المجلدات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# توليد مفتاح التطبيق
RUN php artisan key:generate

# ضبط مجلد العمل العام
WORKDIR /var/www/html/public

# الأمر الافتراضي لتشغيل Laravel
CMD ["php-fpm"]

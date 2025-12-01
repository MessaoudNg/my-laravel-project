# استخدم صورة PHP مناسبة
FROM php:8.1-fpm

# تثبيت الأدوات المطلوبة
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl

# تمكين امتدادات PHP المطلوبة
RUN docker-php-ext-install pdo_mysql zip

# نسخ Composer من الصورة الرسمية
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ضبط مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع
COPY . .

# تثبيت اعتمادات المشروع
RUN composer install --optimize-autoloader --no-dev

# توليد مفتاح التطبيق بعد تثبيت الاعتمادات
RUN php artisan key:generate

# ضبط صلاحيات المجلدات
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ضبط مجلد العمل العام
WORKDIR /var/www/html/public

# تشغيل PHP-FPM
CMD ["php-fpm"]

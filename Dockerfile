FROM php:8.2-apache

# تثبيت امتدادات PHP المطلوبة
RUN docker-php-ext-install pdo pdo_mysql

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع
COPY . /var/www/html/

# تعيين public كمجلد الجذر
WORKDIR /var/www/html/public

# إعطاء أذونات الكتابة
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# توليد مفتاح التطبيق
RUN php /var/www/html/artisan key:generate

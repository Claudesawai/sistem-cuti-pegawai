# 1. Gunakan Base Image PHP resmi dengan Apache
FROM php:8.2-apache

# 2. Install dependencies sistem
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Install ekstensi PHP
RUN docker-php-ext-install gd pdo pdo_mysql mbstring zip exif pcntl bcmath opcache

# 4. FIX KHUSUS: Matikan mpm_event secara paksa dan nyalakan mpm_prefork
# Ini akan menghapus file config mpm_event agar tidak bisa loading sama sekali
RUN a2dismod mpm_event || true && \
    rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf || true && \
    a2enmod mpm_prefork rewrite

# 5. Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# 6. Set working directory
WORKDIR /var/www/html

# 7. Copy file konfigurasi dependency (Optimasi Cache)
# Dengan menyalin ini duluan, 'composer install' tidak akan lari ulang jika hanya kode program yang berubah
COPY composer.json composer.lock ./

# 8. Install dependensi (Tanpa dev untuk produksi, hapus --no-dev jika untuk staging/dev)
RUN composer install --no-scripts --no-autoloader --ansi --no-interaction

# 9. Copy seluruh file project
COPY . .

# 10. Selesaikan instalasi composer (Generate autoload)
RUN composer dump-autoload --optimize

# 11. Set Apache Document Root ke folder 'public' Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 12. Berikan izin akses folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 13. Expose port 80
EXPOSE 80

# 14. Jalankan Apache
CMD ["apache2-foreground"]
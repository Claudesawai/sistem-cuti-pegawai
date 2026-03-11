FROM php:8.2-apache

# ── 1. Install semua library sistem yang dibutuhkan ──
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libwebp-dev \
    libxpm-dev \
    libgd-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# ── 2. Konfigurasi & Install ekstensi PHP ──
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo \
        pdo_mysql \
        mbstring \
        tokenizer \
        xml \
        ctype \
        fileinfo \
        zip \
        opcache \
        bcmath \
        exif \
        pcntl

# ── 3. Konfigurasi Apache ──
RUN a2enmod rewrite

# ── 4. Fix MPM conflict (root cause error AH00534) ──
RUN if [ -f /etc/apache2/mods-enabled/mpm_event.conf ]; then \
        a2dismod mpm_event; \
    fi \
    && a2enmod mpm_prefork

# ── 5. Konfigurasi Apache Virtual Host ──
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
        Options -Indexes +FollowSymLinks\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# ── 6. Konfigurasi PHP optimal untuk production ──
RUN echo "opcache.enable=1\n\
opcache.memory_consumption=128\n\
opcache.interned_strings_buffer=8\n\
opcache.max_accelerated_files=4000\n\
opcache.revalidate_freq=60\n\
opcache.fast_shutdown=1" > /usr/local/etc/php/conf.d/opcache.ini

# ── 7. Install Composer ──
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ── 8. Set working directory ──
WORKDIR /var/www/html

# ── 9. Copy project files ──
COPY . .

# ── 10. Install dependencies Laravel ──
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction \
    --ignore-platform-reqs

# ── 11. Buat folder yang dibutuhkan Laravel ──
RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

# ── 12. Set permissions yang benar ──
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 storage \
    && chmod -R 777 bootstrap/cache

# ── 13. Expose port Apache ──
EXPOSE 80
FROM php:7.3-fpm

# Install dependencies dan PHP extensions
RUN apt-get update && apt-get install -y \
    build-essential \
    zlib1g-dev \
    default-mysql-client \
    curl \
    gnupg \
    procps \
    vim \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl zip pdo_mysql \
  && docker-php-ext-configure gd \
  && docker-php-ext-install gd \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN EXPECTED_SIGNATURE=$(curl -s https://composer.github.io/installer.sig) && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    ACTUAL_SIGNATURE=$(php -r "echo hash_file('sha384', 'composer-setup.php');") && \
    [ "$EXPECTED_SIGNATURE" = "$ACTUAL_SIGNATURE" ] && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php

# Copy konfigurasi PHP dan PHP-FPM
COPY ./.docker/php/php.ini /usr/local/etc/php/
COPY ./.docker/php/docker.conf /usr/local/etc/php-fpm.d/docker.conf
COPY ./.docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www

COPY . .

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Setup Laravel environment & build frontend
RUN cp .env.example .env \
  && php artisan key:generate \
  && php artisan route:cache \
  && php artisan storage:link

# Fix permission
RUN chown -R www-data:www-data /var/www
RUN chown -R www-data.www-data /var/www/bootstrap/cache
RUN chmod 777 /var/www/storage

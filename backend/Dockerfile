FROM php:8.2-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    fish \
    zlib1g-dev \
    g++ \
    git \
    libicu-dev \
    zip \
    wget \
    libzip-dev \
    libpq-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql pgsql pdo_pgsql \
    && pecl install apcu mongodb \
    && docker-php-ext-enable apcu mongodb \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip 

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Установка Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony



WORKDIR /var/www/project




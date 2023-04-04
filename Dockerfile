FROM php:8.1-fpm

ARG user=guilherme
ARG uid=1000

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libpq-dev \
    unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mbstring exif pcntl bcmath gd sockets pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

#@TODO
# RUN apt-get update && apt-get install -y supervisor && mkdir -p /var/log/supervisor
# COPY docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
# CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]

WORKDIR /var/www

COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

USER $user

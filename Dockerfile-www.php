FROM php:8.0-fpm

RUN usermod -u 1001 www-data && groupmod -g 1001 www-data

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        wget \
        libpq-dev \
        zlib1g-dev \
        libzip-dev \
        libxml2-dev

COPY conf/php/php-fpm.ini /usr/local/etc/php/conf.d/php-fpm.ini

RUN docker-php-ext-install pdo pdo_mysql opcache pcntl intl zip bcmath sockets mysqli soap

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY conf/php/entrypoint.sh /entrypoint.sh

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

ENTRYPOINT ["/entrypoint.sh"]

CMD ["php-fpm"]

WORKDIR /var/www

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --prefer-dist \
    --no-interaction \
    --no-ansi \
    --no-scripts

COPY . .

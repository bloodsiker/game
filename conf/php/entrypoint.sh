#!/usr/bin/env sh

set -e

if [ "${PHP_XDEBUG_ENABLED}" = "yes" ]; then
    pecl install xdebug || true
    docker-php-ext-enable xdebug
fi

#if [ "${APP_DEBUG}" = "1" ]; then
#    echo 'alias sf="php bin/console"' >> ~/.bashrc
#fi

#php bin/console cache:clear

#chown -R www-data:www-data var/cache/

exec "$@"

#!/bin/bash

set -e

if [ ! -e /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
    docker-php-ext-enable xdebug
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
    pkill -o -USR2 php-fpm
    touch /app/.xdebug-enabled
    echo "Xdebug enabled"
else
  echo "Xdebug already enabled"
fi

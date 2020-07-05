#!/bin/bash

set -e

if [ -e /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
  rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
  pkill -o -USR2 php-fpm
fi
rm /app/.xdebug-enabled

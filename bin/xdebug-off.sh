#!/bin/bash

set -e

if [ -e /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
  rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
  pkill -o -USR2 php-fpm
  echo "Xdebug disabled"
else
  echo "Xdebug already disabled"
fi

if [ -e /app/.xdebug-enabled ]; then
  rm /app/.xdebug-enabled
fi

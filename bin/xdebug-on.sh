#!/bin/bash

set -e

docker-php-ext-enable xdebug
pkill -o -USR2 php-fpm
touch /app/.xdebug-enabled

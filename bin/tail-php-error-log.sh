#!/bin/bash
#
# This script tails the debug log for WordPress.
#
# WordPressDev, Copyright 2019 Google LLC
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

if [[ ! -e /app/public/content/debug.log ]]; then
    touch /app/public/content/debug.log
fi

echo 'Assuming WP_DEBUG_LOG enabled, tailing /app/public/content/debug.log...'

tail -f /app/public/content/debug.log

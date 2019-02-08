#!/bin/bash

if [[ ! -e /app/public/content/debug.log ]]; then
    touch /app/public/content/debug.log
fi

echo 'Assuming WP_DEBUG_LOG enabled, tailing /app/public/content/debug.log...'

tail -f /app/public/content/debug.log

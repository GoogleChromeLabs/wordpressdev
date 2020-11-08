#!/bin/bash

set -e

if [ -e /app/.xdebug-enabled ]; then
  bash /app/bin/xdebug-on.sh
fi

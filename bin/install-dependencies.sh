#!/bin/bash
#
# This scripts installs WordPressDev environment dependencies.
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

if [[ -z "$LANDO_MOUNT" ]]; then
    echo "Error: Must be run the appserver.";
    exit 1
fi

echo "Installing Dependencies"

apt-get update -y
apt-get -y install libyaml-dev
yes | pecl install yaml
echo 'extension=yaml.so' > /usr/local/etc/php/conf.d/yaml.ini

apt-get install gnupg -y

curl -sL https://deb.nodesource.com/setup_11.x | bash -
apt-get install nodejs -y

curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
apt-get update
apt-get install yarn -y

apt-get install zip -y
apt-get install subversion -y

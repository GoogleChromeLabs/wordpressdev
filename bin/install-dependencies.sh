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

cd "$(dirname "$0")"

echo "Installing Dependencies"
set -xe

apt-get update -y
apt-get -y install libyaml-dev
if yes | pecl install yaml; then
	echo 'extension=yaml.so' > /usr/local/etc/php/conf.d/yaml.ini
else
	echo "Did not install yaml."
fi

apt-get install ca-certificates curl gnupg -y

mkdir -p /etc/apt/keyrings
curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list
apt-get update -y
apt-get install nodejs -y

curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
apt-get update
apt-get install yarn -y

apt-get install zip -y
apt-get install subversion -y

# Download phpunit pahr based on the major version.
if [[ ! -e /usr/local/bin/phpunit ]]; then
	curl -L https://phar.phpunit.de/phpunit-$PHPUNIT_MAJOR.phar -o /usr/local/bin/phpunit
	chmod +x /usr/local/bin/phpunit
fi

# Install dependencies that are unique to the user environment.
if [ -e install-local-dependencies.sh ]; then
	bash ./install-local-dependencies.sh
fi

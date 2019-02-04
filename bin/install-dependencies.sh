#!/bin/bash
# Install wpdev dependencies.

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

curl -sL https://deb.nodesource.com/setup_10.x | bash -
apt-get install nodejs -y

curl -sL https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
apt-get update
apt-get install yarn -y

apt-get install zip -y
apt-get install subversion -y

#!/bin/bash
#

echo "Checking out WordPress trunk. See https://develop.svn.wordpress.org/trunk"
svn co https://develop.svn.wordpress.org/trunk/ "$PWD/trunk"

cd "$PWD/trunk"

echo "Installing local composer packages for {$LANDO_APP_NAME}.{$LANDO_DOMAIN}, this may take several minutes."
composer install

echo "Installing local npm packages for {$LANDO_APP_NAME}.{$LANDO_DOMAIN}, this may take several minutes."
npm install --no-bin-links

echo "Initializing grunt and creating {$LANDO_APP_NAME}.{$LANDO_DOMAIN}/build/, this may take several minutes."
grunt

echo "Creating wp-config.php for {$LANDO_APP_NAME}.{$LANDO_DOMAIN}/src/ and {$LANDO_APP_NAME}.{$LANDO_DOMAIN}/build/."
cp -f "../config/wp-config.php" "./wp-config.php"
cp -f "../config/wp-tests-config.php" "./wp-tests-config.php"

echo "Installing {$LANDO_APP_NAME}.{$LANDO_DOMAIN}."
wp core install --url="{$LANDO_APP_NAME}.{$LANDO_DOMAIN}/build/" --quiet --title="WordPressDev" --admin_name="admin" --admin_email="admin@local.test" --admin_password="password"

cd "$PWD"

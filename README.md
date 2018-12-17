# WordPress Core Development Environment

This is a [WordPress core development](https://core.trac.wordpress.org/browser/trunk/) environment based on [Lando](https://docs.devwithlando.io/).

**Warning:** This is in a very early development stage. You can use it, but expect some failures in certain areas. I'm new to Lando, so still need to figure a few things out.

## Features

* Standalone Development Environment based on Lando, which itself requires Docker
* WordPress Core Development Repository via Subversion
* PHPUnit & PHPCodeSniffer
* NPM & Grunt

## How to Set Up

* Install Lando via a [GitHub DMG file](https://github.com/lando/lando/releases) or via [Homebrew Cask](http://caskroom.io/) (`brew cask install lando`). You also need to have Docker installed (if you install Lando with Homebrew Cask, it will automatically take care of that for you).
* Clone this repository into a directory of your choice. Navigate to that directory.
* Run `lando start`. When doing this for the first time, it will set the environment up for you, so it will take a bit longer than on subsequent starts.
* Run `lando wp-install`. This will download the WordPress core development repository, install necessary dependencies, create a first build, and install WordPress for you.
* Access your site under `https://wordpressdev.lndo.site/build/`.

If this is your very first Lando project, make sure that your system trusts the SSL certificate that Lando generates via: `sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain ~/.lando/certs/lndo.site.pem` You might need to restart your browser to see the change being reflected.

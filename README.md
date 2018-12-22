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
* Access your site under `https://wordpressdev.lndo.site/`. If you're having trouble connecting, you may be facing the [DNS Rebinding Protection issue](https://docs.devwithlando.io/issues/dns-rebind.html). To fix, and to ensure you can develop while offline, follow the [Working Offline](https://docs.devwithlando.io/config/proxy.html#working-offline-or-using-custom-domains) steps. In other words, add the folliwng to your host machine's `/etc/hosts` file:
```
127.0.0.1       wordpressdev.lndo.site
```
* Work with themes and plugins under `core/build/wp-content`. The `core/src` is only for WordPress core sources. You work in the build version of core since core can no longer be run from src. 

If this is your very first Lando project, make sure that your system trusts the SSL certificate that Lando generates via: `sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain ~/.lando/certs/lndo.site.pem` You might need to restart your browser to see the change being reflected.

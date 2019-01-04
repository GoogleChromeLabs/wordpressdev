# WordPress Development Environment

This is a [WordPress development](https://make.wordpress.org) environment based on [Lando](https://docs.devwithlando.io/). It allows for [core development](https://make.wordpress.org/core/), [plugin development](https://make.wordpress.org/plugins/), and [theme development](https://make.wordpress.org/themes/).

**Warning:** This is in a very early development stage. You can use it, but expect some failures in certain areas. I'm new to Lando, so still need to figure a few things out.

## Features

* Standalone Development Environment based on Lando, which itself requires Docker
* WordPress Core Development Repository via [Git](https://github.com/WordPress/wordpress-develop) and [Subversion](https://core.trac.wordpress.org/browser/trunk/)
* WordPress Plugin & Theme Development Environment, decoupled from Core Development Repository
* PHPUnit & PHPCodeSniffer
* NPM & Grunt

## Setup

* Install Lando via a [GitHub DMG file](https://github.com/lando/lando/releases) or via [Homebrew Cask](http://caskroom.io/) (`brew cask install lando`). You also need to have Docker installed (if you install Lando with Homebrew Cask, it will automatically take care of that for you).
* Clone this repository into a directory of your choice. Navigate to that directory.
* Run `lando start`. When doing this for the first time, it will set the environment up for you, so it will take a bit longer than on subsequent starts.
* Access your site under `https://wordpressdev.lndo.site/`. If you're having trouble connecting, you may be facing the [DNS Rebinding Protection issue](https://docs.devwithlando.io/issues/dns-rebind.html). To fix, and to ensure you can develop while offline, follow the [Working Offline](https://docs.devwithlando.io/config/proxy.html#working-offline-or-using-custom-domains) steps. In other words, add the folliwng to your host machine's `/etc/hosts` file:
```
127.0.0.1       wordpressdev.lndo.site
```

If this is your very first Lando project, make sure that your system trusts the SSL certificate that Lando generates via: `sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain ~/.lando/certs/lndo.site.pem` You might need to restart your browser to see the change being reflected.

## Usage

* WordPress core contributions are done in the `public/core-dev` directory which is both a Git clone and SVN checkout. To update the Git and SVN in tandem, do `git svn-up` in that directory to update to the latest `trunk`/`master`. To switch/update another branch, do `git svn-up $branch`. This `git svn-up` command is an alias to the repo's [`bin/svn-git-up`](bin/svn-git-up) script.
* WordPress plugin and theme development should happen in `public/content`, which is a custom `wp-content` directory, decoupled from the WordPress core repository. The environment automatically takes care of setting WordPress constants appropriately so that the core and content directories are connected, so you don't need to worry about this.
* By default, the website you open from the browser will run off the `public/core-dev/build` directory. If you prefer to use WordPress core from another directory (for example `public/core-dev/src`), you need to update the following configurations:
    * all three variables defined in `.env`
    * the path defined in `wp-cli.yml`
    * the hardcoded `WP_TESTS_DIR` value at the very bottom of `.lando.yml`
* You can use `lando stop` to turn off the environment and `lando start` to restart it again later. You can learn more about available commands in the [Lando documentation](https://docs.devwithlando.io/).

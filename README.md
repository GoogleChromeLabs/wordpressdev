# WordPressDev Environment

This is a [WordPress development](https://make.wordpress.org) environment based on [Lando](https://docs.devwithlando.io/). It allows for [core development](https://make.wordpress.org/core/), [plugin development](https://make.wordpress.org/plugins/), and [theme development](https://make.wordpress.org/themes/). It is intended to largely be a Docker-based port of [VVV](https://varyingvagrantvagrants.org/).

**Disclaimer:** There is no official support for this environment. Our team at Google is using it, and we are happy to share it and collaborate on it with the WordPress community. The environment is still in a very early development stage, so use it at your own risk.

## Features

* Standalone Development Environment based on Lando, which itself requires Docker
* WordPress Core Development Repository via [Git](https://github.com/WordPress/wordpress-develop) and [Subversion](https://core.trac.wordpress.org/browser/trunk/), allowing to seamlessly use both within a single directory
* WordPress Plugin & Theme Development Environment, decoupled from Core Development Repository
* PHPUnit & PHPCodeSniffer
* NPM & Grunt

## Setup

* Install the latest version of Lando via a [GitHub DMG file](https://github.com/lando/lando/releases). You also need to have Docker installed, but Lando will take care of that for you if you don't.
* Clone this repository into a directory of your choice. Navigate to that directory.
* Run `lando start`. When doing this for the first time, it will set the environment up for you, so it will take a bit longer than on subsequent starts.
* Access your site under `https://wordpressdev.lndo.site/`. If you're having trouble connecting, you may be facing the [DNS Rebinding Protection issue](https://docs.devwithlando.io/issues/dns-rebind.html). To fix this, and to ensure you can develop while offline, follow the [Working Offline](https://docs.devwithlando.io/config/proxy.html#working-offline-or-using-custom-domains) steps. In other words, add the following to your host machine's `/etc/hosts` file:
```
127.0.0.1       wordpressdev.lndo.site
```

If this is your very first Lando project, make sure that your system trusts the SSL certificate that Lando generates via: `sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain ~/.lando/certs/lndo.site.pem` You might need to restart your browser to see the change being reflected.

An additional note on Lando: The project is currently approaching its version 3.0 release, with frequent RC releases. As this environment is based on that latest version, make sure to check back for [new Lando versions](https://github.com/lando/lando/releases) regularly.

## Usage

#### Contributing to Core

WordPress core contributions are done in the `public/core-dev` directory which is both a Git clone and SVN checkout. To update the Git and SVN in tandem, do `git svn-up` in that directory to update to the latest `trunk`/`master`. To switch/update another branch, do `git svn-up $branch`. This `git svn-up` command is an alias to the repo's [`bin/svn-git-up`](bin/svn-git-up) script.

##### Setup Your Fork

1. Fork the [wordpress-develop](https://github.com/WordPress/wordpress-develop) repository to your GitHub account. 
2. In your teriminal, navigate to the `./public/core-dev` directory.
3. Add the GitHub repository as a remote. 
```git remote add <remote-name> git@github.com:<github-account>/wordpress-develop.git```

You can now pull down from the upstream via `git pull origin` or push to your remote with `git push <remote-name>`.

##### Setup Your Workspace

You will work and commit in the `./public/core-dev/src` directory while your changes are reflected on the frontend from the `./public/core-dev/build` directory. Consult `./public/core-dev/composer.json` or `./public/core-dev/package.json` for avaiable commands such as `npm run watch` to aid your workflow.

1. Create a [Trac ticket](https://make.wordpress.org/core/reports/) with your proposed changes.
2. Create a branch with your ticket ID as reference with `git checkout -b trac-XXXXX`.
3. Watch for file changes by running `npm run watch` from inside the `./public/core-dev/src` directory.
4. Make your changes. 
5. Commit early and often. 
6. Write tests. 
7. Push your changes to your GitHub remote with `git push <remote-name>`.

Now you can view your changes on GitHub and send the pull request to the [wordpress-develop](https://github.com/WordPress/wordpress-develop) repository.

#### Theme and Plugin Development

WordPress plugin and theme development should happen in `public/content`, which is a custom `wp-content` directory, decoupled from the WordPress core repository. The environment automatically takes care of setting WordPress constants appropriately so that the core and content directories are connected, so you don't need to worry about this.

#### Environment Configuration

You can customize the environment. Variables placed in a custom `.env` file in the root directory will override similar variables from the `.env.base` file. Custom CLI configuration can be set up via a `wp-cli.local.yml` file (taking precedence over `wp-cli.yml`), and even custom Lando configuration is possible via a `.lando.yml` file (taking precedence over `.lando.base.yml`). For changes to the Lando configuration or environment variables, you will need to run `lando rebuild` to apply them.

#### Lando Commands

Run `lando stop` to turn off the environment and `lando start` to restart it again later. 

Run `lando phpunit` to perform all tests or `lando phpunit tests/phpunit/tests/<directory-name>` to perform a specific set of tests.

You can learn more about available commands in the [Lando documentation](https://docs.devwithlando.io/) or by running `lando` in your terminal.

## Troubleshooting

If you are having problems after running `landor start` such as `git svn-up` not recognizing the `.svn` or `.git` directories, run `lando rebuild` to rebuild the entire `./public/core-dev` directory.

## Contributing

Any kind of contributions to WordPressDev are welcome. Please [read the contributing guidelines](https://github.com/GoogleChromeLabs/wordpressdev/blob/master/CONTRIBUTING.md) to get started.

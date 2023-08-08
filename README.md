# SEEC Magento2 Module Skeleton

[SEEC](https://www.schimmelmann.org) is building and maintaining Magento1 + Magento2 stores and modules, and we have
some guidelines
which we try to follow when developing plugins. These guidelines are used in this repository, and it gives you a very
solid base when developing plugins.

Enjoy!

# Usage

This is a template repository. Just click the "Use Template" button top right and start creating your own
Magento2 module. Inside the docker container that ships with this repository, you can find everything you need to
test and develop your Magento 2 module.

Once you're done, you can go on the CLI level to your src/ folder and run a `git init` to create the initial
git folders, and then push it to an individual repository.

# Installation

Installing this skeleton is easy, as it will take care for the installation for you on its own during startup.

Prepare the .env.dist file, then build the Dockerfile:

```bash 
cp .env.dist .env
docker compose build
```

This will download Magento already, but not install it yet.

```bash 
docker compose up
```

This will start the docker container, and install Magento2 for you. In case of a fresh installation it will also create
a dummy module for you with the specifications made in
`.env` file. Once done, you will be able to find the files in the `src/` folder of your host machine.

# Configuration

All relevant information can be set up in the `.env` file. The following variables are available:
```dotenv
MAGENTO_PUBLIC_KEY=xxx
MAGENTO_SECRET_KEY=xxx
VENDOR_NAME=SEEC
MODULE_NAME=magento-test-module
```

# Testing
This skeleton injects automatically battle-proven ECS configuration files as well as default PHPSTAN files into the module. 
Also, it requires these packages on its own, as well as our Behat testing suite.

With this, you can use the most comprehensive testing frameworks to ensure great code quality.

Related links:
- [ECS](https://github.com/easy-coding-standard/easy-coding-standard)
- [PHPSTAN](https://github.com/phpstan/phpstan)
- [PHPUnit](https://github.com/sebastianbergmann/phpunit)
- [Behat](https://github.com/Behat/Behat)
- [Magento2 Behat Extension](https://github.com/nopenopenope/behat-magento2-extension)



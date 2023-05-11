# SEEC Magento2 Module Skeleton

[SEEC](https://www.schimmelmann.org) is building and maintaining Magento1 + Magento2 stores and modules, and we have some guidelines
which we try to follow when developing plugins. These guidelines are used in this repository, and it gives you a very
solid base when developing plugins.

Enjoy!

## Quickstart

1. Run `composer create-project --prefer-source --no-install --remove-vcs seec/magento2-module-skeleton:dev-master .` or just click the `Use this template` button at the right corner of this repository.
2. Run `cp .env.dist .env` and edit your keys in there to allow the plugin to install Magento2 correctly, if desired change Magento2 version. Please note that by default this package uses PHP8.2.
3. You can get your keys from here: https://marketplace.magento.com/customer/accessKeys/
4. From the module skeleton root directory, run the following command `make install`
5. Run `docker compose up -d` to start the docker containers

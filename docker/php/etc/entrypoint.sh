#!/usr/bin/env sh

create-auth-file
install-magento

cd /var/www/html

mage2gen-module-creator

cp -a /var/www/html/vendor/magento /var/www/html/vendor/magento-ext
chown -R 1000:1000 /var/www/html/vendor/magento-ext

php bin/magento cache:clean
echo "Setting permissions..."
chown -R 1000:1000 .
echo "Done setting permissions."

exec "$@"

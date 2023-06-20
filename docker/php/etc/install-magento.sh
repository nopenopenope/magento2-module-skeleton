#!/usr/bin/env bash

rm -rf /var/www/html/app/etc/env.php

php bin/magento setup:install \
  --base-url="http://www.magento-skeleton.test:3500/" \
  --admin-email="developer@dev.test" \
  --admin-firstname="Test" \
  --admin-lastname="Test" \
  --admin-password="test123!@#" \
  --admin-user="admin" \
  --backend-frontname="admin" \
  --currency="EUR" \
  --db-host="database" \
  --db-name="magento2" \
  --db-password="magento2" \
  --db-prefix="" \
  --db-user="magento2" \
  --language="en_US" \
  --opensearch-host="opensearch" \
  --opensearch-port="9200" \
  --timezone="Europe/Amsterdam" \
  --use-rewrites="1" \
  --use-sample-data \
  --cleanup-database

php bin/magento module:disable Magento_AdminAdobeImsTwoFactorAuth Magento_TwoFactorAuth
php bin/magento deploy:mode:set developer


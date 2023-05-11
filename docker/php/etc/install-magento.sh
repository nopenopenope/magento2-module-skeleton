#!/usr/bin/env bash

php bin/magento setup:install \
  --base-url="http://www.magento-skeleton.test:3500/" \
  --db-host="database" \
  --db-name="magento2" \
  --db-password="magento2" \
  --db-user="root" \
  --admin-firstname="Admin" \
  --admin-lastname="Admin" \
  --admin-email="developer@dev.test" \
  --admin-user="admin" \
  --admin-password="test123!@#" \
  --use-rewrites="1" \
  --backend-frontname="admin" \
  --opensearch-host="opensearch" \
  --opensearch-port="9200" \
  --use-sample-data

php bin/magento module:disable Magento_AdminAdobeImsTwoFactorAuth Magento_TwoFactorAuth

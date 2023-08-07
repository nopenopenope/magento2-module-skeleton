#!/usr/bin/env bash

if [ -f /var/www/html/app/code/${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}/registration.php ]; then
  echo "[Already existing] registration.php found in /var/www/html/app/code/${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}"
  exit 1
fi

echo "Stage 1: prepare Token from vendor site"
USER_AGENT="Magento2 Module Creator Docker: nopenopenope/magento-module-skeleton"
response_headers=$(curl -Is 'https://mage2gen.com/' \
  --compressed -H "User-Agent: ${USER_AGENT}" \
  -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8' \
  -H 'Accept-Language: de,en-US;q=0.7,en;q=0.3' -H 'Accept-Encoding: gzip, deflate' -H 'DNT: 1' \
  -H 'Connection: keep-alive' -H 'Upgrade-Insecure-Requests: 1' -H 'Sec-Fetch-Dest: document' \
  -H 'Sec-Fetch-Mode: navigate' -H 'Sec-Fetch-Site: none' -H 'Sec-Fetch-User: ?1' \
   -H 'Pragma: no-cache' -H 'Cache-Control: no-cache')

CSRF_TOKEN=$(echo "$response_headers" | grep -iE '^Set-Cookie:' | grep -iE 'csrftoken=' | awk -F 'csrftoken=' '{print $2}' | awk -F ';' '{print $1}')
echo "Extracted CSRF token: $CSRF_TOKEN"

echo "Stage 2: generate basic module"
response=$(curl -s 'https://mage2gen.com/files/' \
  --compressed -X POST -H "User-Agent: ${USER_AGENT}" \
  -H 'Accept: */*' -H 'Accept-Language: de,en-US;q=0.7,en;q=0.3' -H 'Accept-Encoding: gzip, deflate' \
  -H 'Referer: https://mage2gen.com/' -H 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8' \
  -H 'X-Requested-With: XMLHttpRequest' -H 'Origin: https://mage2gen.com' -H 'Connection: keep-alive' \
  -H "Cookie: csrftoken=$CSRF_TOKEN; intro=true" \
  -H 'Sec-Fetch-Dest: empty' -H 'Sec-Fetch-Mode: cors' -H 'Sec-Fetch-Site: same-origin' \
  -H 'Pragma: no-cache' -H 'Cache-Control: no-cache' \
  --data-raw "csrfmiddlewaretoken=$CSRF_TOKEN&mage2gen-data=%7B%22package_name%22%3A%22${VENDOR_NAME:-SEEC}%22%2C%22module_name%22%3A%22${MODULE_NAME:-Test-module-name}%22%2C%22description%22%3A%22Test Module, please change accordingly.%22%2C%22license%22%3A%22gplv3%22%2C%22copyright%22%3A%22%22%2C%22magento_version%22%3A4%2C%22snippets%22%3A%7B%7D%7D")

MODULE_ID=$(echo "$response" | jq -r '.data.module_id') || (echo "Error: could not extract module ID from response: $response" && exit 1)

echo "Stage 3: download module"
curl -s "https://mage2gen.com/download/module/$MODULE_ID.zip" \
  -H "User-Agent: ${USER_AGENT}" \
  -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8' \
  -H 'Accept-Language: de,en-US;q=0.7,en;q=0.3' -H 'Accept-Encoding: gzip, deflate' \
  -H 'Referer: https://mage2gen.com/' -H 'Connection: keep-alive' \
  -H "Cookie: mage2gen_module_id=$MODULE_ID" \
  -H 'Upgrade-Insecure-Requests: 1' -H 'Sec-Fetch-Dest: document' -H 'Sec-Fetch-Mode: navigate' \
  -H 'Sec-Fetch-Site: same-origin' -H 'Sec-Fetch-User: ?1' \
  -H 'Pragma: no-cache' -H 'Cache-Control: no-cache' --output /var/www/html/module.zip

echo "Stage 4: extract module and move to synced folder"
mkdir -p /var/www/html/dummy-module
mv module.zip /var/www/html/dummy-module
cd /var/www/html/dummy-module
unzip module.zip
rm -rf module.zip ${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}/COPYING.txt ${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}/LICENSE.txt

mv ${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}/* ../app/code/${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}/
cd ..
rm -rf dummy-module
chown -R 1000:1000 app/code/${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}/

echo "Stage 5: add default repository and dependencies to module"
cd /var/www/html/app/code/${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}
composer config repositories.magento-repository composer https://repo.magento.com/
composer config --no-plugins allow-plugins.magento/* true
composer config --no-plugins allow-plugins.php-http/discovery true
composer config --no-plugins allow-plugins.phpstan/extension-installer true
composer config --no-plugins allow-plugins.laminas/laminas-dependency-plugin true
composer config --no-plugins allow-plugins.dealerdirect/phpcodesniffer-composer-installer true
composer require --no-progress --dev phpunit/phpunit seec/phpunit-consecutive-params seec/behat-magento2-extension phpstan/phpstan phpstan/extension-installer symplify/easy-coding-standard symplify/config-transformer bitexpert/phpstan-magento

echo "Stage 6: Link development files"
cp /var/www/html/phpstan.neon /var/www/html/app/code/${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}/phpstan.neon
cp /var/www/html/ecs.php /var/www/html/app/code/${VENDOR_NAME:-SEEC}/${MODULE_NAME:-Test-module-name}/ecs.php

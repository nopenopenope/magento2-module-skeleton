#!/usr/bin/env bash

echo "Create auth.json"
mkdir -p ~/.composer/
/usr/bin/envsubst < /docker/scripts/auth.json.tmpl > ~/.composer/auth.json || cat ~/.composer/auth.json

echo "Set permissions for all files and folders"
chown -R www-data:1000 /var/www/html
find /var/www/html -type f -exec chmod 664 {} \;
find /var/www/html -type d -exec chmod 775 {} \;
echo "Done setting permissions"

exec "$@"

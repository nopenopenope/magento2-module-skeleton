#!/usr/bin/env sh

php vendor/bin/ecs check src/ --fix
php vendor/bin/ecs check features/ --fix
php vendor/bin/ecs check tests/ --fix
chown -R 1000:1000 .

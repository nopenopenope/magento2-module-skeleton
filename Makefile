.DEFAULT_GOAL := help

MAGENTO_VERSION?=2.4.6

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "[32m%-40s[0m %s\n", $$1, $$2}'

.PHONY: install
install: # install Magento2 from source
	docker compose up -d
	docker compose exec php composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition:$(MAGENTO_VERSION) . || echo "Cannot create new project, maybe its already existing."
	docker compose exec php composer require symplify/easy-coding-standard --dev
	docker compose exec php composer require --dev phpstan/phpstan
	docker compose exec php composer require --dev phpstan/extension-installer
	docker compose exec php composer require --no-interaction --dev bitexpert/phpstan-magento
	docker compose exec php install-magento

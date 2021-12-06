COMPOSER_ARGS := --ignore-platform-reqs
CI ?= false

ifeq ($(APP_ENV), prod)
	COMPOSER_ARGS := --no-dev --optimize-autoloader $(COMPOSER_ARGS)
endif

PHPMD_ARGS := . text phpmd.xml --suffixes php
ifeq ($(CI),true)
	PHPMD_ARGS := . xml phpmd.xml --suffixes php --report-file var/reports/phpmd.xml
endif

ifeq ($(CI_TYPE), gitlab)
	PHPSTAN_ARGS :=  --error-format gitlab > var/reports/phpstan.json
else ifeq ($(CI_TYPE), github)
	PHPSTAN_ARGS := --error-format github > var/reports/phpstan.json
else
	PHPSTAN_ARGS :=
endif

help:
	@echo "help"

configure:
	@bin/configure

install:
ifeq ($(shell whoami), php)
ifneq ($(APP_ENV), prod)
	@composer install $(COMPOSER_ARGS)
endif
	@make --silent setup-database
else
	@docker-compose up -d --force-recreate
	@sleep 5
	@docker-compose exec php sh -c "make install"
endif

setup-database:
ifeq ($(shell whoami), php)
ifneq ($(APP_ENV), prod)
	@bin/console doctrine:database:create --if-not-exists --no-interaction --env $(APP_ENV)
	@bin/console doctrine:schema:drop --full-database --force --no-interaction --env $(APP_ENV)
endif
	@bin/console doctrine:migrations:migrate --no-interaction --env $(APP_ENV)
ifneq ($(APP_ENV), prod)
	@bin/console doctrine:fixtures:load --purge-with-truncate --no-interaction --env $(APP_ENV)
endif
else
	@docker-compose exec php sh -c "make setup-database"
endif

phpmd:
ifeq ($(shell whoami), php)
	@php -d error_reporting='E_ALL & ~E_NOTICE & ~E_DEPRECATED' ./vendor/bin/phpmd $(PHPMD_ARGS)
else
	@docker-compose exec php sh -c "make phpmd"
endif

phpcs:
ifeq ($(shell whoami), php)
	@php ./vendor/bin/phpcs
else
	@docker-compose exec php sh -c "make phpcs"
endif

phpstan:
ifeq ($(shell whoami), php)
	@php -d memory_limit=10G ./vendor/bin/phpstan analyse -c ./phpstan.neon $(PHPSTAN_ARGS)
else
	@docker-compose exec php sh -c "make phpcs-security-audit"
endif

phpcs-security-audit:
ifeq ($(shell whoami), php)
	@php ./vendor/bin/phpcs --standard=phpcs-security-audit.xml
else
	@docker-compose exec php sh -c "make phpcs-security-audit"
endif

phpunit:
ifeq ($(shell whoami), php)
	@php ./vendor/bin/phpunit
else
	@docker-compose exec php sh -c "make phpunit"
endif

behat: ## inside container run APP_ENV=test
ifeq ($(shell whoami), php)
	@make --silent setup-database
	@php ./vendor/bin/behat
else
	@docker-compose exec php sh -c "make behat"
endif


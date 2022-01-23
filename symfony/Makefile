COMPOSER_ARGS :=
CI ?= false

ifeq ($(APP_ENV), prod)
	COMPOSER_ARGS := --no-dev --optimize-autoloader $(COMPOSER_ARGS)
endif

PHPMD_ARGS := . text phpmd.xml --suffixes php
ifdef ($(CI_TYPE),true)
	PHPMD_ARGS := . xml phpmd.xml --suffixes php --report-file var/reports/phpmd.xml
endif

ifeq ($(CI_TYPE), gitlab)
	PHPSTAN_ARGS :=  --error-format gitlab > var/reports/phpstan.json
else ifeq ($(CI_TYPE), github)
	PHPSTAN_ARGS := --error-format github > var/reports/phpstan.json
else
	PHPSTAN_ARGS :=
endif

BACKUP_APP_ENV := $(shell cat .env | grep "APP_ENV" | cut -d= -f2)

RED=\e[31m
GREEN=\e[32m
YELLOW=\e[33m
BLUE=\e[34m
BOLD=\e[1m
RESET=\e[0m

define HELP
$(BLUE)make [TARGET]$(RESET)

$(BLUE)Target:$(RESET)
	$(GREEN)help$(RESET)					$(YELLOW)Show make help$(RESET)
	$(GREEN)install$(RESET)					$(YELLOW)Dependencies installation and database configuratio$(RESET)
	$(GREEN)setup-database$(RESET)				$(YELLOW)On the prod environment, there is only the migration of the database, otherwise we create a database, we delete the schema, we migrate the database and we load fixtures.$(RESET)
	$(GREEN)phpmd$(RESET)					$(YELLOW)Running PHPMD$(RESET)
	$(GREEN)phpcs$(RESET)					$(YELLOW)Running PHPCS$(RESET)
	$(GREEN)phpstan$(RESET)					$(YELLOW)Running PHPStan$(RESET)
	$(GREEN)phpcs-security-audit$(RESET)			$(YELLOW)Running PHPCS Security Audit$(RESET)
	$(GREEN)lint$(RESET)					$(YELLOW)Running PHPMD PHPCS PHPStan And PHPCS Security Audit$(RESET)
	$(GREEN)phpunit$(RESET)					$(YELLOW)Running PHPUnit$(RESET)
	$(GREEN)behat$(RESET)					$(YELLOW)Running Behat$(RESET)
	$(GREEN)var/reports$(RESET)				$(YELLOW)Creation of the var/reports directory$(RESET)
	$(GREEN)show-upgradable-dependencies$(RESET)		$(YELLOW)List of dependencies that can be updated$(RESET)
$(RESET)
endef
export HELP

help:
	@printf "$$HELP"

install:
	@composer install $(COMPOSER_ARGS)
	@make --silent setup-database

setup-database:
	@bin/wait-for.sh $(POSTGRES_HOST):5432 --timeout 30
ifneq ($(APP_ENV), prod)
	@bin/console doctrine:database:create --if-not-exists --no-interaction --env $(APP_ENV)
	@bin/console doctrine:schema:drop --full-database --force --no-interaction --env $(APP_ENV)
endif
	@bin/console doctrine:migrations:migrate --no-interaction --env $(APP_ENV)
ifneq ($(APP_ENV), prod)
	@bin/console doctrine:fixtures:load --purge-with-truncate --no-interaction --env $(APP_ENV)
endif

phpmd: var/reports
	@php ./vendor/bin/phpmd $(PHPMD_ARGS)

phpcs: var/reports
	@php ./vendor/bin/phpcs

phpstan: var/reports
	@php -d memory_limit=10G ./vendor/bin/phpstan analyse -c ./phpstan.neon $(PHPSTAN_ARGS)

phpcs-security-audit: var/reports
	@php ./vendor/bin/phpcs --standard=phpcs-security-audit.xml

lint: phpmd phpcs phpstan phpcs-security-audit

phpunit: var/reports
	@php ./vendor/bin/phpunit

behat: var/reports ## Run this target with APP_ENV=test for use database test
	@make --silent setup-database
	@php -d display_errors=off ./vendor/bin/behat
	@mv var/reports/default.xml var/reports/behat.xml

.PHONY: tests
tests: phpunit behat

var/reports:
	@mkdir -p $@

show-upgradable-dependencies:
	@composer outdated

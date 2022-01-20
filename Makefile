include .env
-include .env.docker.local

.env.docker.local:
	@touch $@

setup: .env.docker.local
ifndef USER_ID
	@echo "USER_ID=$(shell id -u)" >> .env.docker.local
endif
ifndef GROUP_ID
	@echo "GROUP_ID=$(shell id -u)" >> .env.docker.local
endif

start:
	@docker-compose up -d --force-recreate

stop:
	@docker-compose down -v

ftp:
	@docker-compose exec ftp sh

postgres:
	@docker-compose exec postgres psql

symfony:
	@docker-compose exec symfony sh

vuejs:
	@docker-compose exec vuejs bash

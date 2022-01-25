include .env
-include .env.docker.local

.env.docker.local:
	@touch $@

setup: .env.docker.local
	bin/configure

start:
	@docker-compose up -d --force-recreate

stop:
	@docker-compose down -v

ftp:
	@docker-compose exec ftp sh

postgres:
	@docker-compose exec postgres psql --username=$(POSTGRES_USER) --dbname=$(POSTGRES_DB)

symfony:
	@docker-compose exec symfony sh

vuejs:
	@docker-compose exec vuejs bash


.PHONY: symfony vuejs

help:
	@echo "help"

configure:
	@bin/configure

start:
	@docker-compose up -d

eslint:
ifeq ($(shell whoami), node)
	@echo "eslint"
else
	@docker-compose exec node sh -c "make eslint"
endif

jest:
ifeq ($(shell whoami), node)
	@echo "jest"
else
	@docker-compose exec node sh -c "make jest"
endif



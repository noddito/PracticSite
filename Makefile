# include .env
# export

all: up

cp-env:
	@test -f .env || cp .env-dist .env

migrate:
	@docker-compose exec --user=www-data php yii migrate --interactive=0

up:
	@docker-compose up -d --build --remove-orphans

env:
	@docker-compose exec --user=www-data php bash

env-root:
	@docker-compose exec php bash

down:
	@docker-compose down

down-v:
	@docker-compose down -v

stop:
	@docker-compose stop

install: cp-env up composer-install up yii-app-setup

composer-install:
	@docker-compose exec --user=www-data php composer install

composer-cmd:
	@docker-compose exec --user=www-data php composer $(cmd)

yii-app-setup:
	@docker-compose exec --user=www-data php yii app/setup --interactive=0

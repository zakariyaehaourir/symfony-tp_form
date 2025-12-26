.PHONY: start down down-volumes create-database drop-database install-packages

install: stop down down-volumes start install-packages generate-dev-local-file

stop:
	docker stop $$(docker ps -aq)
start:
	docker compose up -d

down:
	docker compose down

down-volumes:
	docker compose down -v

create-database:
	docker compose exec php php bin/console doctrine:database:create

drop-database:
	docker compose exec php bin/console doctrine:database:drop --force

install-packages:
	docker compose exec php composer install --no-cache

enter: ## Enter a running service container (e.g., make enter service=php)
	@if [ -n "$(service)" ]; then \
		docker compose exec $(service) bash; \
	fi

generate-dev-local-file:
	$(PHP_EXEC) cp .env.dev .env.dev.local

init-database: drop-database drop-database

clear: stop down
	docker system prune
	docker image prune
	docker network prune
	docker builder prune

list:
	docker compose ps

controller: #name controller name=ggController

	@if [ -z "$(name)" ]; then \
		echo "❌ Erreur: Spécifiez un nom pour le contrôleur: make controller name=NomController"; \
		exit 1; \
	fi
	docker compose exec php php bin/console make:controller $(name)

entity:
	@if [ -z "$(name)" ]; then \
		echo "❌ Erreur: Spécifiez un nom: make entity name=NomEntity"; \
		exit 1; \
	fi
	docker compose exec php php bin/console make:entity $(name)

crud:
	@if [ -z "$(name)" ]; then \
		echo "❌ Erreur: Spécifiez un nom: make crud name=NomEntity"; \
		exit 1; \
	fi
	docker compose exec php php bin/console make:crud $(name)

resource:entity crud #combinition : make resource name=Test

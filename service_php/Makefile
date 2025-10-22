
# HOW TO USE THE MAKEFILE
# 
# Start MySQL and PHP services in Docker:
# make run
#
# 
# # Initialize the database (CREATE, INSERT):
# make init-db  
#
# 
# Run Tests:
# make tests (using host's PHPUnit)
# 
# 
# Restart MySQL in Docker (preserves data)
# make restart-db
# 
# 
# Stop and remove all containers and volumes:
# make clean-up
# 
# 
# 
# PREREQUISITES
#
# Ensure Docker and Docker Compose are installed on your system.

#---

# -------------------------------------------------
# Variables – can be overridden on the command line
# -------------------------------------------------
APP_MODE ?= development          # default mode
export APP_MODE  # Makes Docker Compose see it.

COMPOSE_FILE ?= docker-compose.yml

##COMPOSE = docker compose -f $(COMPOSE_FILE)
COMPOSE = docker-compose --env-file env/.env.$(APP_MODE) -f $(COMPOSE_FILE)
#
# -------------------------------------------------
# -------------------------------------------------


.PHONY: run
run: ## Starts MySQL and PHP services for development
	@echo "Starting services in $(APP_MODE) mode..."
	$(COMPOSE) up -d
	###$(COMPOSE) --env-file env/.env.development up -d

.PHONY: stop
stop:        ## Stop and remove containers, networks & volumes
	@echo "Stopping $(APP_MODE) stack"
	$(COMPOSE) down

.PHONY: restart
restart: stop run   ## Restart the stack

.PHONY: logs
logs:        ## Tail logs of all services
	$(COMPOSE) logs -f

.PHONY: ps
ps:          ## Show running containers
	$(COMPOSE) ps


.PHONY: init-db
init-db: ## Initializes the database (create tables, seed data, etc.)
#
# Initializes the database (e.g., creates tables or seeds data).
# Assumes you have an init-db.sql file in your service_php directory
#
	@echo "Initializing database..."
	@docker compose --env-file env/.env.development exec mysql sh -c 'read -s -p "Enter MySQL root password: " DB_ROOT_PASS \
		&& mysql -uroot -p$DB_ROOT_PASS $(DB_NAME) < init-db.sql'


.PHONY: tests
tests: ## Runs PHPUnit tests using host's PHPUnit
#
	@echo "Running PHPUnit tests..."
	@docker compose exec php /usr/local/bin/php /opt/lampp/bin/phpunit --verbose --colors=always
#


.PHONY: restart-db
restart-db: ## Restarts MySQL in Docker (preserves data)
	@echo "Restarting MySQL..."
	@docker compose --env-file env/.env.development  restart mysql


.PHONY: clean-up
clean-up: ## Cleans up Docker containers and volumes
# 
# Stops and removes all containers, networks, and volumes.
# Useful for a fresh start.
#
	@echo "Cleaning up..."
	@docker compose --env-file env/.env.development  down -v


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

### # Define variables at the top of the Makefile
### DB_USER := $(DB_USER)
### DB_USER := db_user_1
### DB_PASS := mySecurePassword354_352
### DB_NAME := account_microservice_db
### DB_ROOT_PASS := root

### MYSQL_PORT := 3306
### MYSQL_VOLUME := mysql_data

#---

## .PHONY: run-development
## run-development: ## Start MySQL and PHP services

.PHONY: run
run ## Start MySQL and PHP services
	@echo "Starting services... (dev)"
	@docker-compose --env-file env/.env.development up -d

.PHONY: run-staging
run-staging: ## Start MySQL and PHP services for staging
	@echo "Starting staging services..."
	@docker-compose --env-file env/.env.staging up -d

.PHONY: run-production
run-production: ## Start MySQL and PHP services for production
	@echo "Starting production services..."
	@docker-compose --env-file env/.env.production up -d

.PHONY: init-db
init-db: ## Initialize the database (create tables, seed data, etc.)
#
# Initializes the database (e.g., creates tables or seeds data).
# Assumes you have an init-db.sql file in your service_php directory
#
	@echo "Initializing database..."
	@docker-compose exec mysql mysql -uroot -p$(DB_ROOT_PASS) $(DB_NAME) < init-db.sql


.PHONY: tests
tests: ## Run PHPUnit tests using host's PHPUnit
#
	@echo "Running PHPUnit tests..."
	@docker-compose exec php /usr/local/bin/php /opt/lampp/bin/phpunit --verbose --colors=always
#


.PHONY: restart-db
restart-db: ## Restart MySQL in Docker (preserves data)
	@echo "Restarting MySQL..."
	@docker-compose restart mysql


.PHONY: clean-up ## Clean up Docker containers and volumes
# 
# Stops and removes all containers, networks, and volumes.
# Useful for a fresh start.
#
	@echo "Cleaning up..."
	@docker-compose down -v

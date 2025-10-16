
# HOW TO USE THE MAKEFILE
# 
# Start MySQL:
# make db
#
#
# # Initialize the database
# make dbinit  
#
# 
# Run the PHP Service:
# make run
# 
# 
# Run Tests:
# make tests
# 
# 
# Stop and Remove MySQL:
# make dbrm
# 
# 
# Clean Up Everything:
# make clean
# 
# 
# 
# PREREQUISITES
#
# Ensure Docker and Docker Compose are installed on your system.

#---

# Define variables at the top of the Makefile
DB_USER := db_user_1
DB_PASS := mySecurePassword354_352
DB_NAME := account_microservice_db
DB_ROOT_PASS := root

MYSQL_PORT := 3306
MYSQL_VOLUME := mysql_data


#---

.PHONY: tests
tests: ## Run PHPUnit tests
#
# Runs PHPUnit tests inside the php container.
# Assumes you have PHPUnit installed in the container (via composer).
#
	@echo "Running PHPUnit tests..."
	@docker-compose exec php vendor/bin/phpunit -v --colors=always


.PHONY: run
run: ## Run the PHP service
#
# Starts the PHP service in detached mode (-d).
# Uses docker-compose up to start the service.
#
	@echo "Starting PHP service..."
	@docker-compose up -d php


.PHONY: dbrm
dbrm: ## Stop and remove MySQL in Docker
#
# Stops and removes the MySQL container.
# Useful for cleaning up after testing.
#
	@echo "Stopping and removing MySQL..."
	@docker stop mysql
	@docker rm mysql


.PHONY: db
db: ## Run MySQL in Docker
# 
# Starts a MySQL container with your custom credentials.
# Maps port 3306 and uses a volume (mysql_data) for persistent data.
#
	@echo "Running MySQL..."
	@docker run -d --name mysql \
		-p $(MYSQL_PORT):$(MYSQL_PORT) \
		-e MYSQL_ROOT_PASSWORD=$(DB_ROOT_PASS) \
		-e MYSQL_DATABASE=$(DB_NAME) \
		-e MYSQL_USER=$(DB_USER) \
		-e MYSQL_PASSWORD=$(DB_PASS) \
		-v $(MYSQL_VOLUME):/var/lib/mysql \
		mysql:8.0


.PHONY: dbinit
dbinit: ## Initialize the database (create tables, seed data, etc.)
#
# Initializes the database (e.g., creates tables or seeds data).
# Assumes you have an init.sql file in your service_php directory
#
	@echo "Initializing database..."
	@if [ "$(docker inspect -f '{{.State.Running}}' mysql)" = "true" ]; then \
		\
		docker exec -i mysql mysql -uroot -p$(DB_ROOT_PASS) $(DB_NAME) < init.sql \
			|| echo "Warning: Failed to initialize database."; \
		\
	else \
		\
		echo "Error: MySQL container is not running. Start it with 'make db'."; \
		\
	fi


clean: ## Clean up Docker containers and volumes
# 
# Stops and removes all containers, networks, and volumes.
# Useful for a fresh start.
#
	@echo "Cleaning up..."
	@docker-compose down -v
	@docker volume rm mysql_data

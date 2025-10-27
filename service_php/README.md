# PHP Account Service
A PHP microservice for managing accounts, using MySQL.

## API Endpoints
- `GET /devops/devops-capstone-project--practice/service_php/accounts`: List all accounts.
- `GET /devops/devops-capstone-project--practice/service_php/accounts/{id}`: Get account by ID.
- `POST /devops/devops-capstone-project--practice/service_php/accounts`: Create a new account.
- `PUT /devops/devops-capstone-project--practice/service_php/accounts/{id}`: Update an account.
- `DELETE /devops/devops-capstone-project--practice/service_php/accounts/{id}`: Delete an account.

## Example Requests
### Create an Account
```bash
curl -X POST -H "Content-Type: application/json" -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "address": "123 Main St",
    "phone_number": "555-1234"
}' http://localhost/devops/devops-capstone-project--practice/service_php/accounts



## Notes

*** Useful Commands ***

# Re-build:
docker compose --env-file env/.env.container build

# Run a shell inside the container:
docker exec -it service_php-php-1 /bin/bash


*** ENVIRONMENT VARIABLE MAPPINGS *** 

The environment variables defined in the selected .env file (specified in the Makefile) 
are mapped to the MySQL service in 'docker-compose.yml' as follows:

   - MYSQL_DATABASE:      Gets its value from ${DB_NAME}
   - MYSQL_USER:          Gets its value from ${DB_USER}
     ...


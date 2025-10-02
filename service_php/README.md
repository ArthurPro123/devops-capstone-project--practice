# PHP Account Service

A PHP microservice for managing accounts, using MySQL.

## Setup

1. Ensure MySQL is running at `/opt/lampp/mysql`.
2. Run the setup script to create the database, user, and tables.

## API Endpoints

- `GET /service_php/accounts`: List all accounts.
- `GET /service_php/accounts/{id}`: Get account by ID.
- `POST /service_php/accounts`: Create a new account.
- `PUT /service_php/accounts/{id}`: Update an account.
- `DELETE /service_php/accounts/{id}`: Delete an account.

## Example Requests

### Create an Account
```bash
curl -X POST -H "Content-Type: application/json" -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "address": "123 Main St",
    "phone_number": "555-1234"
}' http://localhost/service_php/accounts

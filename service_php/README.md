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

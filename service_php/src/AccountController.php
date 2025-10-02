<?php
require_once __DIR__ . '/Account.php';
header("Content-Type: application/json");

// Extract the path segments
$path = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$request_method = $_SERVER['REQUEST_METHOD'];

// Initialize the Account object
$account = new Account();

// Handle the request
switch ($request_method) {
    case 'GET':
        if (isset($path[1]) && is_numeric($path[1])) {
            // GET /accounts/{id}
            $result = $account->getById($path[1]);
            echo json_encode($result);
        } else {
            // GET /accounts
            $result = $account->getAll();
            echo json_encode($result);
        }
        break;

    case 'POST':
        // POST /accounts
        $input = json_decode(file_get_contents('php://input'), true);
        $success = $account->create($input['name'], $input['email'], $input['address'], $input['phone_number']);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        // PUT /accounts/{id}
        $input = json_decode(file_get_contents('php://input'), true);
        $success = $account->update($path[1], $input['name'], $input['email'], $input['address'], $input['phone_number']);
        echo json_encode(['success' => $success]);
        break;

    case 'DELETE':
        // DELETE /accounts/{id}
        $success = $account->delete($path[1]);
        echo json_encode(['success' => $success]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>

<?php
require_once __DIR__ . '/Account.php';

header("Content-Type: application/json");

$account = new Account();
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($request[0]) && is_numeric($request[0])) {
            // Get account by ID
            $result = $account->getById($request[0]);
            echo json_encode($result);
        } else {
            // Get all accounts
            $result = $account->getAll();
            echo json_encode($result);
        }
        break;

    case 'POST':
        // Create account
        $success = $account->create($input['name'], $input['email'], $input['address'], $input['phone_number']);
        echo json_encode(['success' => $success]);
        break;

    case 'PUT':
        // Update account
        $success = $account->update($request[0], $input['name'], $input['email'], $input['address'], $input['phone_number']);
        echo json_encode(['success' => $success]);
        break;

    case 'DELETE':
        // Delete account
        $success = $account->delete($request[0]);
        echo json_encode(['success' => $success]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>

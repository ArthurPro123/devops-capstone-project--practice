<?php

require_once __DIR__ . '/Account.php';
header("Content-Type: application/json");

// Extract the path segments
$path = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];

// Changed $path to make it work with containers:
# # $raw = $_GET['request'] ?? '';
# # $path = $raw ? explode('/', trim($raw, '/')) : [];


$request_method = $_SERVER['REQUEST_METHOD'];

// Initialize the Account object
$account = new Account();

// Handle the request
if (empty($path)) {
    // Handle root URL: /
    if ($request_method === 'GET') {
        echo json_encode([
            'name' => 'Account REST API Service',
            'version' => '1.0',
            'endpoints' => [
                'health' => '/health',
                'accounts' => '/accounts',
                'account' => '/accounts/{id}'
            ],
						'additional_information' => $debugging_information
        ]
				
				);
        exit;
    }
} else {
    switch ($path[0]) {
        case 'health':
            if ($request_method === 'GET') {
                echo json_encode(['status' => 'OK']);
                exit;
            }
            break;

        case 'accounts':
            switch ($request_method) {
                case 'GET':
                    if (isset($path[1]) && is_numeric($path[1])) {
                        // GET /accounts/{id}
                        $result = $account->getById($path[1]);
												$result['additional_information'] = $debugging_information;
                        echo json_encode($result);
                    } else {
                        // GET /accounts
                        $result = $account->getAll();
												$result['additional_information'] = $debugging_information;
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
                    if (isset($path[1]) && is_numeric($path[1])) {
                        $input = json_decode(file_get_contents('php://input'), true);
                        $success = $account->update($path[1], $input['name'], $input['email'], $input['address'], $input['phone_number']);
                        echo json_encode(['success' => $success]);
                    }
                    break;

                case 'DELETE':
                    // DELETE /accounts/{id}
                    if (isset($path[1]) && is_numeric($path[1])) {
                        $success = $account->delete($path[1]);
                        echo json_encode(['success' => $success]);
                    }
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(['error' => 'Method not allowed']);
                    break;
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
            break;
    }
}
?>

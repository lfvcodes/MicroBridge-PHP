<?php
/*
# API Endpoint 2 - Secondary API handler
# 
# This endpoint demonstrates a simple data retrieval service that can be
# called by other APIs through MicroBridge.
# 
# @author lfvcodes
# @link https://github.com/lfvcodes/MicroBridge-PHP.git
*/

// Set JSON response header
header('Content-Type: application/json');

// Enable CORS for local testing
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    echo json_encode(['message' => 'Preflight OK']);
    exit;
}

// Get request method and data
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$query = $_GET;

// Handle requests based on HTTP method
switch ($method) {
    case 'GET':
        if (isset($query['id'])) {
            // Simulate data retrieval
            $mockData = [
                'id' => $query['id'],
                'name' => 'Sample User ' . $query['id'],
                'email' => 'user' . $query['id'] . '@example.com',
                'created_at' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];

            echo json_encode([
                'status' => 200,
                'message' => 'Data retrieved successfully from API2',
                'data' => $mockData,
                'api_info' => [
                    'endpoint' => 'api2',
                    'version' => '1.0',
                    'timestamp' => time()
                ]
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'status' => 400,
                'error' => 'Bad Request',
                'message' => 'ID parameter is required'
            ]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode([
            'status' => 405,
            'error' => 'Method Not Allowed',
            'message' => sprintf('HTTP method %s is not supported by this endpoint', $method),
            'allowed_methods' => ['GET']
        ]);
        break;
}

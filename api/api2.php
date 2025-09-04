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
            echo json_encode([
                'status' => 400,
                'error' => 'Bad Request',
                'message' => 'ID parameter is required'
            ]);
        }
        break;

    default:
        echo json_encode([
            'status' => 405,
            'error' => 'Method Not Allowed',
            'message' => sprintf('HTTP method %s is not supported by this endpoint', $method),
            'allowed_methods' => ['GET']
        ]);
        break;
}

<?php

/*
# API Endpoint 1 - Main API handler
#
# This endpoint demonstrates request handling and chaining to other APIs.
# It supports multiple HTTP methods and includes proper error handling.
#
# @author lfvcodes
# @link https://github.com/lfvcodes/MicroBridge-PHP.git
*/

require_once '../vendor/autoload.php';

use MicroBridge\MicroBridge;

// Get request method and data
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$query = $_GET;

// Handle requests based on HTTP method
switch ($method) {
    case 'GET':
        if (isset($query['id'])) {
            try {
                // Chain request to another API endpoint
                $bridge = new MicroBridge('GET');
                $payload = ['id' => $query['id']];

                $response = $bridge->request('api/api2.php', $payload);

                // Add metadata to response
                $response['api1_metadata'] = [
                    'processed_at' => date('Y-m-d H:i:s'),
                    'request_id' => uniqid('req_', true),
                    'chained_from' => 'api1'
                ];

                echo json_encode($response);
            } catch (\Exception $e) {
                echo json_encode([
                    'status' => 500,
                    'error' => 'Internal server error',
                    'message' => $e->getMessage()
                ]);
            }
        } else {
            echo json_encode([
                'status' => 400,
                'error' => 'Bad Request',
                'message' => 'ID parameter is required'
            ]);
        }
        break;

    case 'POST':
        echo json_encode([
            'status' => 201,
            'method' => 'POST',
            'body' => $input,
            'message' => 'Resource created successfully'
        ]);
        break;

    case 'PUT':
        echo json_encode([
            'status' => 200,
            'method' => 'PUT',
            'body' => $input,
            'message' => 'Resource updated successfully'
        ]);
        break;

    case 'PATCH':
        echo json_encode([
            'status' => 200,
            'method' => 'PATCH',
            'body' => $input,
            'message' => 'Resource partially updated successfully'
        ]);
        break;

    case 'DELETE':
        echo json_encode([
            'status' => 200,
            'method' => 'DELETE',
            'body' => $input,
            'message' => 'Resource deleted successfully'
        ]);
        break;

    default:
        echo json_encode([
            'status' => 405,
            'error' => 'Method Not Allowed',
            'message' => sprintf('HTTP method %s is not supported by this endpoint', $method),
            'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE']
        ]);
        break;
}

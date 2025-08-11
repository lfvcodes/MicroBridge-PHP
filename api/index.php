<?php
header('Content-Type: application/json');

// Permitir CORS para pruebas locales
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

#Manejar preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    echo json_encode(['message' => 'Preflight OK']);
    exit;
}

#Obtener método y datos
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$query = $_GET;

#Simular respuesta según verbo
switch ($method) {
    case 'GET':
        echo json_encode([
            'method' => 'GET',
            'query' => $query,
            'message' => 'Received GET request'
        ]);
        break;

    case 'POST':
        echo json_encode([
            'method' => 'POST',
            'body' => $input,
            'message' => 'Received POST request'
        ]);
        break;

    case 'PUT':
        echo json_encode([
            'method' => 'PUT',
            'body' => $input,
            'message' => 'Received PUT request'
        ]);
        break;

    case 'DELETE':
        echo json_encode([
            'method' => 'DELETE',
            'body' => $input,
            'message' => 'Received DELETE request'
        ]);
        break;

    case 'PATCH':
        echo json_encode([
            'method' => 'PATCH',
            'body' => $input,
            'message' => 'Received PATCH request'
        ]);
        break;

    default:
        http_response_code(405);
        echo json_encode([
            'error' => 'Method Not Allowed',
            'method' => $method
        ]);
        break;
}

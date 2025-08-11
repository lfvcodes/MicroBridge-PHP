<?php
/*
#author: @lfvcodes
https://github.com/lfvcodes/MicroBridge-PHP.git
*/

use MicroBridge\MicroBridge;

header('Content-Type: application/json');

#Allow CORS for local testing / Permitir CORS para pruebas locales
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

#Manage preflight options / Manejar preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    echo json_encode(['message' => 'Preflight OK']);
    exit;
}

#Get method and data / Obtener método y datos
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?? [];
$query = $_GET;

#Simulate response according to verb / Simular respuesta según verbo
switch ($method) {
    case 'GET':
        if (isset($query['id'])) {

            $bridge = new MicroBridge('GET');
            $payload = [
                'id' => $query['id']
            ];

            $response = $bridge->request('./api/api2.php', $payload); //CALL ANOTHER API
            echo json_encode($response);
        } else {
            echo json_encode([
                'status' => 400,
                'error' => 'ID Parametter is required'
            ]);
        }
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

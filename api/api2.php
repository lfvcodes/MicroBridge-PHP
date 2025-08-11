<?php
/*
#author: @lfvcodes
https://github.com/lfvcodes/MicroBridge-PHP.git
*/
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

      echo json_encode([
        'status' => 200,
        'message' => 'Info from api2 success',
        'result' => [0 => ['id' => 'idnumber']]
      ]);
    } else {
      echo json_encode([
        'status' => 400,
        'error' => 'ID Parametter is required'
      ]);
    }
    break;

  default:
    http_response_code(405);
    echo json_encode([
      'error' => 'Method Not Allowed',
      'method' => $method
    ]);
    break;
}

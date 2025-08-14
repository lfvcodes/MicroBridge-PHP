<?php

namespace MicroBridge;

use MicroBridge\RequestContext;
use MicroBridge\MockPhpStream;

class MicroBridge
{

  private $method;

  public function __construct($verb = 'POST')
  {
    $this->method = strtoupper($verb);
  }

  public function request(string $url, array $payload = [], $headers = [])
  {

    if (!is_array($payload)) {
      throw new \InvalidArgumentException('Payload must be an array.');
    }

    $context = new RequestContext();
    $context->save();

    $requestData = $payload;
    $cleanUrl = $url;

    if ($this->method === 'GET') {
      $parsedUrl = parse_url($url);

      $cleanUrl = $parsedUrl['path'] ?? '';

      if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $urlParams);
        $requestData = array_merge($urlParams, $payload);
      }
    }

    // Configurar variables globales según el método
    switch ($this->method) {
      case 'GET':
        $_GET = $requestData;
        $_REQUEST = $requestData;
        break;

      case 'POST':
      case 'PUT':
      case 'PATCH':
      case 'DELETE':
        $_POST = $requestData;
        $_REQUEST = $requestData;
        break;
    }

    // Configurar el entorno del servidor simulado
    $serverVars = [
      'REQUEST_METHOD' => $this->method,
      'CONTENT_TYPE' => 'application/json; charset=UTF-8',
      'HTTP_REFERER' => $_SERVER['HTTP_HOST'] . '/',
      'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
    ];

    // Agregar headers personalizados
    foreach ($headers as $key => $value) {
      $normalized = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
      $serverVars[$normalized] = $value;
    }

    $_SERVER = array_merge($_SERVER, $serverVars);

    // Simular php://input para métodos que lo usan
    if (in_array($this->method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
      $_POST = $requestData;
      $GLOBALS['php_input_content'] = json_encode($requestData);

      if (in_array('php', stream_get_wrappers())) {
        stream_wrapper_unregister('php');
      }

      stream_wrapper_register('php', 'MicroBridge\MockPhpStream');
    }

    // Capturar la salida

    try {
      ob_start();
      include $cleanUrl;
      $response = ob_get_clean();
    } catch (\Throwable $e) {
      ob_end_clean();
      return ['error' => true, 'message' => $e->getMessage()];
    }

    // Restaurar el estado original
    $context->restore();

    if (in_array($this->method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
      if (class_exists('PHPStream')) {
        stream_wrapper_restore('php');
      }
      unset($GLOBALS['php_input_content']);
    }

    $decoded = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
      return ['error' => true, 'message' => 'Invalid JSON response'];
    }
    return $decoded;
  }
}

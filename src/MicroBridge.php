<?php

namespace MicroBridge;

use MicroBridge\RequestContext;
use MicroBridge\MockPhpStream;

/**
 * MicroBridge - Lightweight PHP microservices/API communicator
 *
 * This class provides a simple interface for making internal API requests
 * within a PHP application, simulating HTTP requests without network overhead.
 *
 * @package MicroBridge
 * @author lfvcodes
 * @version 1.0.0
 */
class MicroBridge
{
    /**
     * HTTP method for the request
     * @var string
     */
    private $method;

    /**
     * Supported HTTP methods
     * @var array
     */
    private const SUPPORTED_METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    /**
     * Constructor
     *
     * @param string $verb HTTP method (GET, POST, PUT, PATCH, DELETE)
     * @throws \InvalidArgumentException If unsupported HTTP method is provided
     */
    public function __construct($verb = 'POST')
    {
        $method = strtoupper($verb);

        if (!in_array($method, self::SUPPORTED_METHODS, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unsupported HTTP method: %s. Supported methods: %s',
                    $verb,
                    implode(', ', self::SUPPORTED_METHODS)
                )
            );
        }

        $this->method = $method;
    }

    /**
     * Execute an internal API request
     *
     * @param string $url Target URL or file path
     * @param array $payload Request data
     * @param array $headers Additional headers
     * @return array Response data or error information
     * @throws \InvalidArgumentException If payload is not an array
     */
    public function request(string $url, array $payload = [], array $headers = []): array
    {
        if (empty(trim($url))) {
            return ['error' => true, 'message' => 'URL cannot be empty'];
        }

        if (!is_array($payload)) {
            throw new \InvalidArgumentException('Payload must be an array.');
        }

        $context = new RequestContext();
        $context->save();

        try {
            return $this->executeRequest($url, $payload, $headers, $context);
        } catch (\Throwable $e) {
            $context->restore();
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Execute the actual request
     *
     * @param string $url Target URL
     * @param array $payload Request data
     * @param array $headers Request headers
     * @param RequestContext $context Request context to restore
     * @return array Response data
     */
    private function executeRequest(string $url, array $payload, array $headers, RequestContext $context): array
    {
        $requestData = $payload;
        $cleanUrl = $url;

        if ($this->method === 'GET') {
            $parsedUrl = parse_url($url);

            if ($parsedUrl === false) {
                return ['error' => true, 'message' => 'Invalid URL format'];
            }

            $cleanUrl = $parsedUrl['path'] ?? '';

            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $urlParams);
                $requestData = array_merge($urlParams, $payload);
            }
        }

        $this->setupGlobalVariables($requestData);
        $this->setupServerEnvironment($headers);

        if (in_array($this->method, ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            $this->setupPhpInputStream($requestData);
        }

        $response = $this->captureResponse($cleanUrl);
        $this->cleanup($context);

        return $this->parseResponse($response);
    }

    /**
     * Setup global variables based on HTTP method
     *
     * @param array $requestData Request data
     */
    private function setupGlobalVariables(array $requestData): void
    {
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
    }

    /**
     * Setup server environment variables
     *
     * @param array $headers Custom headers
     */
    private function setupServerEnvironment(array $headers): void
    {
        $serverVars = [
            'REQUEST_METHOD' => $this->method,
            'CONTENT_TYPE' => 'application/json; charset=UTF-8',
            'HTTP_REFERER' => ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/',
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
        ];

        // Add custom headers
        foreach ($headers as $key => $value) {
            $normalized = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
            $serverVars[$normalized] = $value;
        }

        $_SERVER = array_merge($_SERVER, $serverVars);
    }

    /**
     * Setup PHP input stream for request body methods
     *
     * @param array $requestData Request data
     */
    private function setupPhpInputStream(array $requestData): void
    {
        $_POST = $requestData;
        $GLOBALS['php_input_content'] = json_encode($requestData);

        if (in_array('php', stream_get_wrappers(), true)) {
            stream_wrapper_unregister('php');
        }

        stream_wrapper_register('php', 'MicroBridge\MockPhpStream');
    }

    /**
     * Capture response from included file
     *
     * @param string $cleanUrl File path to include
     * @return string Response content
     * @throws \Exception If file cannot be included
     */
    private function captureResponse(string $cleanUrl): string
    {
        if (!file_exists($cleanUrl)) {
            throw new \Exception("Target file does not exist: {$cleanUrl}");
        }

        if (!is_readable($cleanUrl)) {
            throw new \Exception("Target file is not readable: {$cleanUrl}");
        }

        ob_start();
        include $cleanUrl;
        return ob_get_clean();
    }

    /**
     * Cleanup resources and restore context
     *
     * @param RequestContext $context Request context to restore
     */
    private function cleanup(RequestContext $context): void
    {
        $context->restore();

        if (in_array($this->method, ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            if (in_array('php', stream_get_wrappers(), true)) {
                stream_wrapper_restore('php');
            }
            unset($GLOBALS['php_input_content']);
        }
    }

    /**
     * Parse and validate response
     *
     * @param string $response Raw response content
     * @return array Parsed response or error information
     */
    private function parseResponse(string $response): array
    {
        if (empty($response)) {
            return ['error' => true, 'message' => 'Empty response received'];
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'error' => true,
                'message' => 'Invalid JSON response: ' . json_last_error_msg(),
                'raw_response' => $response
            ];
        }

        return $decoded;
    }
}

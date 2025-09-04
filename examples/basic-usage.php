<?php
/**
 * Basic Usage Example for MicroBridge-PHP
 * 
 * This example demonstrates the fundamental usage patterns of MicroBridge
 * for internal API communication.
 */

require_once '../vendor/autoload.php';

use MicroBridge\MicroBridge;

echo "<h1>MicroBridge-PHP Basic Usage Examples</h1>\n";

// Example 1: Simple GET request
echo "<h2>Example 1: GET Request</h2>\n";
try {
    $bridge = new MicroBridge('GET');
    $response = $bridge->request('../api/api1.php', ['id' => 123]);
    
    echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT) . "</pre>\n";
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
}

// Example 2: POST request with data
echo "<h2>Example 2: POST Request</h2>\n";
try {
    $bridge = new MicroBridge('POST');
    $response = $bridge->request('../api/api1.php', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'action' => 'create_user'
    ]);
    
    echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT) . "</pre>\n";
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
}

// Example 3: PUT request with headers
echo "<h2>Example 3: PUT Request with Headers</h2>\n";
try {
    $bridge = new MicroBridge('PUT');
    $response = $bridge->request('../api/api1.php', 
        ['id' => 123, 'status' => 'updated'],
        ['Authorization' => 'Bearer sample-token']
    );
    
    echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT) . "</pre>\n";
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
}

// Example 4: Error handling
echo "<h2>Example 4: Error Handling</h2>\n";
try {
    $bridge = new MicroBridge('INVALID_METHOD');
} catch (Exception $e) {
    echo "<p style='color: orange;'>Caught expected error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
}

echo "<p><em>Examples completed successfully!</em></p>\n";
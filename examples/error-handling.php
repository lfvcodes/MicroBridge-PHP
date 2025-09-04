<?php
/**
 * Error Handling Example for MicroBridge-PHP
 * 
 * This example demonstrates various error scenarios and how MicroBridge
 * handles them gracefully.
 */

require_once '../vendor/autoload.php';

use MicroBridge\MicroBridge;

echo "<h1>MicroBridge-PHP Error Handling Examples</h1>\n";

/**
 * Demonstrate various error scenarios
 */
function demonstrateErrorHandling()
{
    echo "<h2>Error Handling Scenarios</h2>\n";
    
    // Scenario 1: Invalid HTTP method
    echo "<h3>1. Invalid HTTP Method</h3>\n";
    try {
        $bridge = new MicroBridge('INVALID');
    } catch (Exception $e) {
        echo "<p style='color: orange;'>✅ Caught expected error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
    }
    
    // Scenario 2: Empty URL
    echo "<h3>2. Empty URL</h3>\n";
    try {
        $bridge = new MicroBridge('GET');
        $response = $bridge->request('');
        
        if ($response['error']) {
            echo "<p style='color: orange;'>✅ Handled empty URL: " . htmlspecialchars($response['message']) . "</p>\n";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Unexpected error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
    }
    
    // Scenario 3: Non-existent file
    echo "<h3>3. Non-existent File</h3>\n";
    try {
        $bridge = new MicroBridge('GET');
        $response = $bridge->request('./non-existent-file.php');
        
        if ($response['error']) {
            echo "<p style='color: orange;'>✅ Handled missing file: " . htmlspecialchars($response['message']) . "</p>\n";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Unexpected error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
    }
    
    // Scenario 4: Invalid payload type
    echo "<h3>4. Invalid Payload Type</h3>\n";
    try {
        $bridge = new MicroBridge('POST');
        $response = $bridge->request('../api/api1.php', 'invalid-payload');
    } catch (Exception $e) {
        echo "<p style='color: orange;'>✅ Caught invalid payload error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
    }
    
    // Scenario 5: Successful request for comparison
    echo "<h3>5. Successful Request (for comparison)</h3>\n";
    try {
        $bridge = new MicroBridge('GET');
        $response = $bridge->request('../api/api2.php', ['id' => 42]);
        
        if (!isset($response['error']) || !$response['error']) {
            echo "<p style='color: green;'>✅ Successful request:</p>\n";
            echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT) . "</pre>\n";
        } else {
            echo "<p style='color: red;'>❌ Request failed: " . htmlspecialchars($response['message']) . "</p>\n";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Unexpected error: " . htmlspecialchars($e->getMessage()) . "</p>\n";
    }
}

demonstrateErrorHandling();

echo "<p><em>Error handling demonstration completed!</em></p>\n";
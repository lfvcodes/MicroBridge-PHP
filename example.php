<?php

/*
# MicroBridge-PHP Example Usage
#
# This file demonstrates how to use MicroBridge for internal API communication.
# It shows a simple GET request to a local API endpoint.
#
# @author lfvcodes
# @link https://github.com/lfvcodes/MicroBridge-PHP.git
*/

require 'vendor/autoload.php';

use MicroBridge\MicroBridge;

try {
    // Initialize MicroBridge with GET method
    // Supported methods: GET, POST, PUT, PATCH, DELETE
    $bridge = new MicroBridge('GET');

    // Make request to local API endpoint
    // Parameters: URL, payload data, optional headers
    $response = $bridge->request('./api/api1.php', ['id' => 1]);

    // Display response
    echo "<h2>API Response:</h2>\n";
    echo "<pre>" . json_encode($response, JSON_PRETTY_PRINT) . "</pre>\n";
} catch (\Exception $e) {
    echo "<h2>Error:</h2>\n";
    echo "<p style='color: red;'>" . htmlspecialchars($e->getMessage()) . "</p>\n";
}

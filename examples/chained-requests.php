<?php
/**
 * Chained Requests Example for MicroBridge-PHP
 * 
 * This example demonstrates how to chain multiple API requests together,
 * showing the power of internal API communication.
 */

require_once '../vendor/autoload.php';

use MicroBridge\MicroBridge;

echo "<h1>MicroBridge-PHP Chained Requests Example</h1>\n";

/**
 * Simulate a complex workflow with multiple API calls
 */
function demonstrateChainedRequests()
{
    echo "<h2>Workflow: User Creation → Profile Setup → Notification</h2>\n";
    
    try {
        // Step 1: Create user
        echo "<h3>Step 1: Creating User</h3>\n";
        $userBridge = new MicroBridge('POST');
        $userResponse = $userBridge->request('../api/api1.php', [
            'action' => 'create_user',
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com'
        ]);
        
        echo "<pre>" . json_encode($userResponse, JSON_PRETTY_PRINT) . "</pre>\n";
        
        if (isset($userResponse['error']) && $userResponse['error']) {
            throw new Exception('User creation failed: ' . $userResponse['message']);
        }
        
        // Step 2: Setup user profile (simulated)
        echo "<h3>Step 2: Setting Up Profile</h3>\n";
        $profileBridge = new MicroBridge('PUT');
        $profileResponse = $profileBridge->request('../api/api1.php', [
            'action' => 'setup_profile',
            'user_id' => 'user_123',
            'preferences' => [
                'theme' => 'dark',
                'notifications' => true
            ]
        ]);
        
        echo "<pre>" . json_encode($profileResponse, JSON_PRETTY_PRINT) . "</pre>\n";
        
        // Step 3: Send welcome notification (simulated)
        echo "<h3>Step 3: Sending Welcome Notification</h3>\n";
        $notificationBridge = new MicroBridge('POST');
        $notificationResponse = $notificationBridge->request('../api/api1.php', [
            'action' => 'send_notification',
            'user_id' => 'user_123',
            'type' => 'welcome',
            'message' => 'Welcome to our platform!'
        ]);
        
        echo "<pre>" . json_encode($notificationResponse, JSON_PRETTY_PRINT) . "</pre>\n";
        
        echo "<p style='color: green;'><strong>Workflow completed successfully!</strong></p>\n";
        
    } catch (Exception $e) {
        echo "<p style='color: red;'><strong>Workflow failed:</strong> " . htmlspecialchars($e->getMessage()) . "</p>\n";
    }
}

demonstrateChainedRequests();
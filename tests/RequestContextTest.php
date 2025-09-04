<?php

namespace MicroBridge\Tests;

use PHPUnit\Framework\TestCase;
use MicroBridge\RequestContext;

/**
 * Test suite for RequestContext class
 * 
 * @package MicroBridge\Tests
 */
class RequestContextTest extends TestCase
{
    /**
     * Test save and restore functionality
     */
    public function testSaveAndRestore()
    {
        // Set initial values
        $_GET = ['test' => 'value'];
        $_POST = ['post' => 'data'];
        $_SERVER['TEST'] = 'original';
        
        $context = new RequestContext();
        $context->save();
        
        // Modify values
        $_GET = ['modified' => 'value'];
        $_POST = ['modified' => 'data'];
        $_SERVER['TEST'] = 'modified';
        
        // Restore original values
        $context->restore();
        
        // Assert original values are restored
        $this->assertEquals(['test' => 'value'], $_GET);
        $this->assertEquals(['post' => 'data'], $_POST);
        $this->assertEquals('original', $_SERVER['TEST']);
    }
    
    /**
     * Test handling of uninitialized superglobals
     */
    public function testHandleUninitializedSuperglobals()
    {
        // Temporarily unset superglobals
        $originalGet = $_GET ?? [];
        $originalPost = $_POST ?? [];
        
        unset($_GET, $_POST);
        
        $context = new RequestContext();
        $context->save();
        
        // Should not throw errors
        $context->restore();
        
        // Restore original values
        $_GET = $originalGet;
        $_POST = $originalPost;
        
        $this->assertTrue(true); // Test passes if no exceptions thrown
    }
}
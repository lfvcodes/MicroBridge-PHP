<?php

namespace MicroBridge\Tests;

use PHPUnit\Framework\TestCase;
use MicroBridge\MicroBridge;

/**
 * Test suite for MicroBridge class
 * 
 * @package MicroBridge\Tests
 */
class MicroBridgeTest extends TestCase
{
    /**
     * Test constructor with valid HTTP methods
     */
    public function testConstructorWithValidMethods()
    {
        $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
        
        foreach ($methods as $method) {
            $bridge = new MicroBridge($method);
            $this->assertInstanceOf(MicroBridge::class, $bridge);
        }
    }
    
    /**
     * Test constructor with invalid HTTP method
     */
    public function testConstructorWithInvalidMethod()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported HTTP method: INVALID');
        
        new MicroBridge('INVALID');
    }
    
    /**
     * Test constructor with case insensitive methods
     */
    public function testConstructorCaseInsensitive()
    {
        $bridge = new MicroBridge('get');
        $this->assertInstanceOf(MicroBridge::class, $bridge);
        
        $bridge = new MicroBridge('Post');
        $this->assertInstanceOf(MicroBridge::class, $bridge);
    }
    
    /**
     * Test request with empty URL
     */
    public function testRequestWithEmptyUrl()
    {
        $bridge = new MicroBridge('GET');
        $response = $bridge->request('');
        
        $this->assertArrayHasKey('error', $response);
        $this->assertTrue($response['error']);
        $this->assertEquals('URL cannot be empty', $response['message']);
    }
    
    /**
     * Test request with non-existent file
     */
    public function testRequestWithNonExistentFile()
    {
        $bridge = new MicroBridge('GET');
        $response = $bridge->request('./non-existent-file.php');
        
        $this->assertArrayHasKey('error', $response);
        $this->assertTrue($response['error']);
        $this->assertStringContainsString('does not exist', $response['message']);
    }
    
    /**
     * Test request with invalid payload type
     */
    public function testRequestWithInvalidPayload()
    {
        $this->expectException(\TypeError::class);
        
        $bridge = new MicroBridge('POST');
        $bridge->request('./some-file.php', 'invalid-payload');
    }
}
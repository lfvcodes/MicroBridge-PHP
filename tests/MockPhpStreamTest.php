<?php

namespace MicroBridge\Tests;

use PHPUnit\Framework\TestCase;
use MicroBridge\MockPhpStream;

/**
 * Test suite for MockPhpStream class
 * 
 * @package MicroBridge\Tests
 */
class MockPhpStreamTest extends TestCase
{
    /**
     * Test stream operations
     */
    public function testStreamOperations()
    {
        $testData = 'test stream content';
        $GLOBALS['php_input_content'] = $testData;
        
        $stream = new MockPhpStream();
        
        // Test stream_open
        $this->assertTrue($stream->stream_open('php://input', 'r', 0, $opened_path));
        
        // Test stream_read
        $content = $stream->stream_read(4);
        $this->assertEquals('test', $content);
        
        // Test stream_tell
        $this->assertEquals(4, $stream->stream_tell());
        
        // Test stream_eof
        $this->assertFalse($stream->stream_eof());
        
        // Read remaining content
        $remaining = $stream->stream_read(100);
        $this->assertEquals(' stream content', $remaining);
        
        // Test EOF after reading all content
        $this->assertTrue($stream->stream_eof());
        
        // Test stream_stat
        $this->assertIsArray($stream->stream_stat());
        
        // Cleanup
        unset($GLOBALS['php_input_content']);
    }
    
    /**
     * Test stream seek functionality
     */
    public function testStreamSeek()
    {
        $testData = 'seekable content';
        $GLOBALS['php_input_content'] = $testData;
        
        $stream = new MockPhpStream();
        $stream->stream_open('php://input', 'r', 0, $opened_path);
        
        // Test SEEK_SET
        $this->assertTrue($stream->stream_seek(4, SEEK_SET));
        $this->assertEquals(4, $stream->stream_tell());
        
        // Test SEEK_CUR
        $this->assertTrue($stream->stream_seek(2, SEEK_CUR));
        $this->assertEquals(6, $stream->stream_tell());
        
        // Test SEEK_END
        $this->assertTrue($stream->stream_seek(-3, SEEK_END));
        $this->assertEquals(strlen($testData) - 3, $stream->stream_tell());
        
        // Cleanup
        unset($GLOBALS['php_input_content']);
    }
}
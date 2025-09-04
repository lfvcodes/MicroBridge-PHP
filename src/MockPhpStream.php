<?php

namespace MicroBridge;

/**
 * MockPhpStream - Mock implementation of PHP's input stream
 * 
 * This class provides a mock implementation of the php://input stream
 * to simulate request body content for internal API requests.
 * 
 * @package MicroBridge
 */
class MockPhpStream
{
    /**
     * Current position in the stream
     * @var int
     */
    private $position = 0;
    
    /**
     * Stream data content
     * @var string
     */
    private $data;

    /**
     * Open the stream
     * 
     * @param string $path Stream path
     * @param string $mode Access mode
     * @param int $options Stream options
     * @param string|null $opened_path Opened path reference
     * @return bool Always returns true
     */
    public function stream_open($path, $mode, $options, &$opened_path): bool
    {
        $this->data = $GLOBALS['php_input_content'] ?? '';
        $this->position = 0;
        return true;
    }

    /**
     * Read data from the stream
     * 
     * @param int $count Number of bytes to read
     * @return string Data read from stream
     */
    public function stream_read($count): string
    {
        $ret = substr($this->data, $this->position, $count);
        $this->position += strlen($ret);
        return $ret;
    }

    /**
     * Check if end of stream is reached
     * 
     * @return bool True if at end of stream
     */
    public function stream_eof(): bool
    {
        return $this->position >= strlen($this->data);
    }

    /**
     * Get stream statistics
     * 
     * @return array Empty array as no real file stats are needed
     */
    public function stream_stat(): array
    {
        return [];
    }

    /**
     * Get current position in stream
     * 
     * @return int Current position
     */
    public function stream_tell(): int
    {
        return $this->position;
    }

    /**
     * Seek to position in stream
     * 
     * @param int $offset Offset to seek to
     * @param int $whence Seek mode
     * @return bool True on success
     */
    public function stream_seek($offset, $whence = SEEK_SET): bool
    {
        switch ($whence) {
            case SEEK_SET:
                $this->position = $offset;
                break;
            case SEEK_CUR:
                $this->position += $offset;
                break;
            case SEEK_END:
                $this->position = strlen($this->data) + $offset;
                break;
            default:
                return false;
        }
        
        return true;
    }
}

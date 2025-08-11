<?php

namespace MicroBridge;

class MockPhpStream
{
  private $position = 0;
  private $data;

  public function stream_open($path, $mode, $options, &$opened_path)
  {
    $this->data = $GLOBALS['php_input_content'] ?? '';
    return true;
  }

  public function stream_read($count): string
  {
    $ret = substr($this->data, $this->position, $count);
    $this->position += strlen($ret);
    return $ret;
  }

  public function stream_eof()
  {
    return $this->position >= strlen($this->data);
  }

  public function stream_stat()
  {
    return [];
  }
}

<?php

namespace MicroBridge;

class RequestContext
{
  private $originalGet;
  private $originalPost;
  private $originalRequest;
  private $originalServer;
  private $originalCookie;
  private $originalFiles;

  public function __construct()
  {
    $this->originalGet = [];
    $this->originalPost = [];
    $this->originalRequest = [];
    $this->originalServer = [];
    $this->originalCookie = [];
    $this->originalFiles = [];
  }

  public function save(): void
  {
    $this->originalGet     = $_GET;
    $this->originalPost    = $_POST;
    $this->originalRequest = $_REQUEST;
    $this->originalServer  = $_SERVER;
    $this->originalCookie  = $_COOKIE;
    $this->originalFiles   = $_FILES;
  }

  public function restore(): void
  {
    $_GET     = $this->originalGet;
    $_POST    = $this->originalPost;
    $_REQUEST = $this->originalRequest;
    $_SERVER  = $this->originalServer;
    $_COOKIE  = $this->originalCookie;
    $_FILES   = $this->originalFiles;
  }
}

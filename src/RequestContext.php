<?php

namespace MicroBridge;

/**
 * RequestContext - Manages PHP superglobal state preservation and restoration
 * 
 * This class is responsible for saving and restoring the state of PHP superglobals
 * to ensure that internal API requests don't interfere with the main application state.
 * 
 * @package MicroBridge
 */
class RequestContext
{
    /**
     * Original $_GET state
     * @var array
     */
    private $originalGet;
    
    /**
     * Original $_POST state
     * @var array
     */
    private $originalPost;
    
    /**
     * Original $_REQUEST state
     * @var array
     */
    private $originalRequest;
    
    /**
     * Original $_SERVER state
     * @var array
     */
    private $originalServer;
    
    /**
     * Original $_COOKIE state
     * @var array
     */
    private $originalCookie;
    
    /**
     * Original $_FILES state
     * @var array
     */
    private $originalFiles;

    /**
     * Constructor - Initialize empty arrays for all superglobals
     */
    public function __construct()
    {
        $this->originalGet = [];
        $this->originalPost = [];
        $this->originalRequest = [];
        $this->originalServer = [];
        $this->originalCookie = [];
        $this->originalFiles = [];
    }

    /**
     * Save current state of all PHP superglobals
     * 
     * This method captures the current state of all superglobals so they can
     * be restored later, preventing interference between requests.
     */
    public function save(): void
    {
        $this->originalGet     = $_GET ?? [];
        $this->originalPost    = $_POST ?? [];
        $this->originalRequest = $_REQUEST ?? [];
        $this->originalServer  = $_SERVER ?? [];
        $this->originalCookie  = $_COOKIE ?? [];
        $this->originalFiles   = $_FILES ?? [];
    }

    /**
     * Restore previously saved state of all PHP superglobals
     * 
     * This method restores the superglobals to their state before the
     * save() method was called, ensuring clean state management.
     */
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

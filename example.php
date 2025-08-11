<?php
require 'vendor/autoload.php';

use MicroBridge\MicroBridge;

$bridge = new MicroBridge('POST'); // GET,POST,PUT,PATCH,DELETE
$response = $bridge->request('./api/index.php', $data = []); //local api url (use name of file with extension)
print_r($response);

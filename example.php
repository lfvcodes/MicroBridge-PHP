<?php
/*
#author: @lfvcodes
https://github.com/lfvcodes/MicroBridge-PHP.git
*/

require 'vendor/autoload.php';

use MicroBridge\MicroBridge;

$bridge = new MicroBridge('GET'); // GET,POST,PUT,PATCH,DELETE
$response = $bridge->request('./api/api1.php', $data = ['id' => 1]); //local api url (use name of file with extension)
print_r($response);

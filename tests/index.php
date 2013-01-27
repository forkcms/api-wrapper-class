<?php

//require
require_once '../../../autoload.php';
require_once 'config.php';

use \ForkCms\Api\Api;

// create instance
$api = new Api(URL, EMAIL, APIKEY);

try {
//    $response = $api->coreGetAPIKey(EMAIL, PASSWORD);
//    $response = $api->coreGetInfo();
//    $response = $api->coreAppleAddDevice(APPLE_DEVICE_TOKEN);
//    $response = $api->coreAppleRemoveDevice(APPLE_DEVICE_TOKEN);
} catch (Exception $e) {
    var_dump($e);
}

// output
var_dump($response);

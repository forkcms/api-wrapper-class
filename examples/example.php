<?php

//require
require_once '../../../autoload.php';
require_once __DIR__ . '/credentials.php';

use \ForkCms\Api\ForkCms;

// create instance
$api = new ForkCms($url, $email, $apiKey);

try {
//    $response = $api->coreGetAPIKey(EMAIL, PASSWORD);
//    $response = $api->coreGetInfo();
//    $response = $api->coreAppleAddDevice(APPLE_DEVICE_TOKEN);
//    $response = $api->coreAppleRemoveDevice(APPLE_DEVICE_TOKEN);
//    $response = $api->blogCommentsGet();
//    $response = $api->blogCommentsGetById(40);
//    $response = $api->blogCommentsUpdate(40, null, 'FooBar');
//    $response = $api->blogCommentsUpdateStatus(array(39, 40), 'published');
} catch (Exception $e) {
    var_dump($e);
}

// output
var_dump($response);

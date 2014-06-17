<?php

// define credentials for the fork cms based website you try to connect to
$url = ''; // required
$email = ''; // required
$apiKey = ''; // required

// username and password are required
if (empty($url) || empty($email) || empty($apiKey)) {
    echo 'Please define your url, email or app key in ' . __DIR__ . '/credentials.php';
}

<?php

require_once '../../../autoload.php';
require_once 'config.php';
require_once 'PHPUnit/Framework/TestCase.php';

use \ForkCms\Api\Api;

/**
 * Api test case.
 */
class ApiTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Api
     */
    private $api;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        // call parent
        parent::setUp();

        // create instance
        $this->api = new Api(URL, EMAIL, APIKEY);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // unset instance
        $this->api = null;

        // call parent
        parent::tearDown();
    }

    /**
     * Tests Api->getTimeOut()
     */
    public function testGetTimeOut()
    {
        $this->api->setTimeOut(5);
        $this->assertEquals(5, $this->api->getTimeOut());
    }

    /**
     * Tests Api->getUserAgent()
     */
    public function testGetUserAgent()
    {
        $this->api->setUserAgent('testing/1.0.0');
        $this->assertEquals(
            'PHP ForkAPI/' . Api::VERSION . ' testing/1.0.0',
            $this->api->getUserAgent()
        );
    }

    /**
     * Tests Api->coreGetAPIKey()
     */
    public function testCoreGetAPIKey()
    {
        $var = $this->api->coreGetAPIKey(EMAIL, PASSWORD);
        $this->assertArrayHasKey('api_key', $var);
    }

    /**
     * Tests Api->coreGetInfo()
     */
    public function testCoreGetInfo()
    {
        $var = $this->api->coreGetInfo();
        $this->assertArrayHasKey('languages', $var);
        foreach ($var['languages'] as $row) {
            $this->assertArrayHasKey('language', $row);
            $this->assertArrayHasKey('title', $row['language']);
            $this->assertArrayHasKey('url', $row['language']);
            $this->assertArrayHasKey('@attributes', $row['language']);
            $this->assertArrayHasKey('language', $row['language']['@attributes']);
        }
    }

    /**
     * Tests Api->coreAppleAddDevice()
     */
    public function testCoreAppleAddDevice()
    {
        $var = $this->api->coreAppleAddDevice(APPLE_DEVICE_TOKEN);
        $this->assertNull($var);
    }

    /**
     * Tests Api->coreAppleRemoveDevice()
     */
    public function testCoreAppleRemoveDevice()
    {
        $var = $this->api->coreAppleRemoveDevice(APPLE_DEVICE_TOKEN);
        $this->assertNull($var);
    }
}

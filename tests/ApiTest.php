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

    /**
     * tests Api->blogCommentsGet()
     */
    public function testBlogCommentsGet()
    {
        $var = $this->api->blogCommentsGet();
        $this->assertArrayHasKey('comments', $var);
        foreach ($var['comments'] as $row) {
            $this->assertArrayHasKey('comment', $row);
            $this->assertArrayHasKey('article', $row['comment']);
            $this->assertArrayHasKey('@attributes', $row['comment']['article']);
            $this->assertArrayHasKey('id', $row['comment']['article']['@attributes']);
            $this->assertArrayHasKey('lang', $row['comment']['article']['@attributes']);
            $this->assertArrayHasKey('title', $row['comment']['article']);
            $this->assertArrayHasKey('url', $row['comment']['article']);
            $this->assertArrayHasKey('@attributes', $row['comment']);
            $this->assertArrayHasKey('id', $row['comment']['@attributes']);
            $this->assertArrayHasKey('created_on', $row['comment']['@attributes']);
            $this->assertArrayHasKey('status', $row['comment']['@attributes']);
            $this->assertArrayHasKey('text', $row['comment']);
            $this->assertArrayHasKey('url', $row['comment']);
            $this->assertArrayHasKey('author', $row['comment']);
            $this->assertArrayHasKey('@attributes', $row['comment']['author']);
            $this->assertArrayHasKey('email', $row['comment']['author']['@attributes']);
            $this->assertArrayHasKey('name', $row['comment']['author']);
            $this->assertArrayHasKey('website', $row['comment']['author']);
        }
    }

    /**
     * Tests Api->blogCommentsGetById()
     */
    public function testBlogCommentsGetById()
    {
        $var = $this->api->blogCommentsGetById(40);
        $this->assertArrayHasKey('comments', $var);
        $this->assertArrayHasKey('comment', $var['comments'][0]);
        $this->assertArrayHasKey('article', $var['comments'][0]['comment']);
        $this->assertArrayHasKey('@attributes', $var['comments'][0]['comment']['article']);
        $this->assertArrayHasKey('id', $var['comments'][0]['comment']['article']['@attributes']);
        $this->assertArrayHasKey('lang', $var['comments'][0]['comment']['article']['@attributes']);
        $this->assertArrayHasKey('title', $var['comments'][0]['comment']['article']);
        $this->assertArrayHasKey('url', $var['comments'][0]['comment']['article']);
        $this->assertArrayHasKey('@attributes', $var['comments'][0]['comment']);
        $this->assertArrayHasKey('id', $var['comments'][0]['comment']['@attributes']);
        $this->assertArrayHasKey('created_on', $var['comments'][0]['comment']['@attributes']);
        $this->assertArrayHasKey('status', $var['comments'][0]['comment']['@attributes']);
        $this->assertArrayHasKey('text', $var['comments'][0]['comment']);
        $this->assertArrayHasKey('url', $var['comments'][0]['comment']);
        $this->assertArrayHasKey('author', $var['comments'][0]['comment']);
        $this->assertArrayHasKey('@attributes', $var['comments'][0]['comment']['author']);
        $this->assertArrayHasKey('email', $var['comments'][0]['comment']['author']['@attributes']);
        $this->assertArrayHasKey('name', $var['comments'][0]['comment']['author']);
        $this->assertArrayHasKey('website', $var['comments'][0]['comment']['author']);
    }

    /**
     * Tests Api->blogCommentsUpdate()
     */
    public function testBlogCommentsUpdate()
    {
        $authorName = 'John Doe';

        $var = $this->api->blogCommentsUpdate(40, null, null, $authorName);
        $this->assertNull($var);
        $var = $this->api->blogCommentsGetById(40);
        $this->assertEquals($authorName, $var['comments'][0]['comment']['author']['name']);
    }

    /**
     * Tests Api->blogCommentsUpdateStatus()
     */
    public function testBlogCommentsUpdateStatus()
    {
        $var = $this->api->blogCommentsUpdateStatus(array(39, 40), 'published');
        $this->assertNull($var);
    }
}

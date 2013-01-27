<?php

namespace ForkCms\Api;

/**
 * @author			Tijs Verkoyen <php-fork-api@verkoyen.eu>
 * @version			1.0.0
 * @copyright		Copyright (c) 2008, Tijs Verkoyen. All rights reserved.
 * @license			BSD License
 */
class Api
{
    // internal constant to enable/disable debugging
    const DEBUG = false;

    // current version
    const VERSION = '1.0.0';

    /**
     * The timeout
     *
     * @var	int
     */
    private $timeOut = 10;

    /**
     * The user agent
     *
     * @var	string
     */
    private $userAgent;

    /**
     * Default constructor
     */
    public function __construct()
    {
    }

    /**
     * Get the timeout that will be used
     *
     * @return int
     */
    public function getTimeOut()
    {
        return (int) $this->timeOut;
    }

    /**
     * Get the useragent that will be used. Our version will be prepended to
     * yours.
     * It will look like: "PHP ForkAPI/<version> <your-user-agent>"
     *
     * @return string
     */
    public function getUserAgent()
    {
        return (string) 'PHP ForkAPI/'. self::VERSION .' '. $this->userAgent;
    }

    /**
     * Set the timeout
     * After this time the request will stop. You should handle any errors triggered by this.
     *
     * @return void
     * @param  int  $seconds The timeout in seconds.
     */
    public function setTimeOut($seconds)
    {
        $this->timeOut = (int) $seconds;
    }

    /**
     * Set the user-agent for you application
     * It will be appended to ours, the result will look like: "PHP ForkAPI/<version> <your-user-agent>"
     *
     * @return void
     * @param  string $userAgent Your user-agent, it should look like <app-name>/<app-version>.
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = (string) $userAgent;
    }
}

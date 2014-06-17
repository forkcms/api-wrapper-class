<?php

namespace ForkCms\Api;

/**
 * @author			Tijs Verkoyen <php-fork-api@verkoyen.eu>
 * @version			1.0.1
 * @copyright		Copyright (c) 2008, Tijs Verkoyen. All rights reserved.
 * @license			BSD License
 */
class Api
{
    // current version
    const VERSION = '1.0.1';

    /**
     * The API key to use for authentication
     *
     * @var  string
     */
    private $apiKey;

    /**
     * The e-mail address to use for authentication
     *
     * @var string
     */
    private $email;

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
     * The url to communicate on
     *
     * @var string
     */
    private $url;

    /**
     * Default constructor
     */
    public function __construct($url, $email = null, $apiKey = null)
    {
        $this->setUrl($url);
        if ($email !== null) {
            $this->setEmail($email);
        }
        if ($apiKey !== null) {
            $this->setApiKey($apiKey);
        }
    }

    /**
     * Make the call
     *
     * @param  string $method       The method to call.
     * @param  array  $parameters   The parameters to pass.
     * @param  string $httpMethod   The HTTP method to use.
     * @param  bool   $authenticate Should we use authentication?
     * @return mixed
     */
    public function doCall(
        $method,
        array $parameters = null,
        $httpMethod = 'GET',
        $authenticate = true
    ) {
        // build the url
        $url = $this->getUrl();

        $parameters['method'] = (string) $method;
        $parameters['format'] = 'json';

        // when we need authentication we need to add some extra parameters
        if ($authenticate) {
            $parameters['email'] = $this->getEmail();
            $parameters['nonce'] = md5(microtime(true) + rand(0, time()));
            $parameters['secret'] = $this->getSecret($parameters['nonce']);
        }

        // HTTP method
        if ($httpMethod == 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = http_build_query($parameters);
        } else {
            $options[CURLOPT_POST] = false;
            if (!empty($parameters)) {
                $url .= '?' . http_build_query($parameters);
            }
        }

        // set options
        $options[CURLOPT_URL] = $url;
        $options[CURLOPT_USERAGENT] = $this->getUserAgent();
        if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
            $options[CURLOPT_FOLLOWLOCATION] = true;
        }
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_TIMEOUT] = (int) $this->getTimeOut();
        $options[CURLOPT_SSL_VERIFYPEER] = false;
        $options[CURLOPT_SSL_VERIFYHOST] = false;

        // init
        $curl = curl_init();

        // set options
        curl_setopt_array($curl, $options);

        // execute
        $response = curl_exec($curl);
        $headers = curl_getinfo($curl);

        // fetch errors
        $errorNumber = curl_errno($curl);
        $errorMessage = curl_error($curl);

        // close
        curl_close($curl);

        $json = json_decode($response, true);

        if (
            !isset($json['meta']['status_code']) ||
            !isset($json['data'])
        ) {
            throw new Exception('Invalid response');
        }

        if ($json['meta']['status_code'] != 200) {
            throw new Exception(
                $json['meta']['status'],
                $json['meta']['status_code']
            );
        }

        // we expect JSON, so decode it
        return $json['data'];
    }

    /**
     * get the API key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Get the e-mail address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the timeout that will be used
     *
     * @return int
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * Calculate the secret
     *
     * @param  string $nonce
     * @return string
     */
    private function getSecret($nonce)
    {
        $base = $this->getEmail();
        $base .= $this->getApiKey();

        return sha1(md5($nonce) . md5($base));
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
        return 'PHP ForkAPI/'. self::VERSION .' '. $this->userAgent;
    }

    /**
     * Get the URL of the website we are working on
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the API key
     *
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Set the e-mail address
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * It will be appended to ours, the result will look like:
     * "PHP ForkAPI/<version> <your-user-agent>"
     *
     * @return void
     * @param  string $userAgent Your user-agent, it should look like <app-name>/<app-version>.
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = (string) $userAgent;
    }

    /**
     * Set the URL to work on
     *
     * @param string $url
     */
    protected function setUrl($url)
    {
        // make sure there is a / on the end
        $url = trim((string) $url, '/') . '/';

        $this->url = (string) $url;
    }

    /**
     * Get the API key for a user
     *
     * @param  string $email
     * @param  string $password
     * @return array
     */
    public function coreGetAPIKey($email, $password)
    {
        // build parameters
        $parameters['email'] = (string) $email;
        $parameters['password'] = (string) $password;

        // make the call
        return $this->doCall('core.getAPIKey', $parameters, 'GET', false);
    }

    /**
     * Get info about the site.
     *
     * @return array
     */
    public function coreGetInfo()
    {
        return $this->doCall('core.getInfo', null, 'GET');
    }

    /**
     * Add a Apple device token to a user
     *
     * @param string $token
     */
    public function coreAppleAddDevice($token)
    {
        // build parameters
        $parameters['token'] = (string) $token;

        // make the call
        $this->doCall('core.apple.addDevice', $parameters, 'POST');
    }

    /**
     * Remove a Apple device token from a user
     *
     * @param string $token
     */
    public function coreAppleRemoveDevice($token)
    {
        // build parameters
        $parameters['token'] = (string) $token;

        // make the call
        $this->doCall('core.apple.removeDevice', $parameters, 'POST');
    }

    /**
     * Get the comments
     *
     * @param  string[optional] $status The type of comments to get. Possible values are: published, moderation, spam.
     * @param  int[optional]    $limit  The maximum number of items to retrieve.
     * @param  int[optional]    $offset The offset.
     * @return mixed
     */
    public function blogCommentsGet($status = null, $limit = null, $offset = null)
    {
        // build parameters
        $parameters = null;
        if ($status !== null) {
            $parameters['status'] = (string) $status;
        }
        if ($limit !== null) {
            $parameters['limit'] = (int) $limit;
        }
        if ($offset !== null) {
            $parameters['offset'] = (int) $offset;
        }

        // make the call
        return $this->doCall('blog.comments.get', $parameters);
    }

    /**
     * Get a single comment.
     *
     * @param  string $id
     * @return mixed
     */
    public function blogCommentsGetById($id)
    {
        // build parameters
        $parameters['id'] = (string) $id;

        // make the call
        return $this->doCall('blog.comments.getById', $parameters);
    }

    /**
     * Update a comment
     *
     * @param string           $id            The id of the comment.
     * @param string[optional] $status        The new status for the comment. Possible values are: published, moderation, spam.
     * @param string[optional] $text          The new text for the comment.
     * @param string[optional] $authorName    The new author for the comment.
     * @param string[optional] $authorEmail   The new email for the comment.
     * @param string[optional] $authorWebsite The new website for the comment.
     */
    public function blogCommentsUpdate(
        $id,
        $status = null,
        $text = null,
        $authorName = null,
        $authorEmail = null,
        $authorWebsite = null
    ) {
        // build parameters
        $parameters['id'] = (string) $id;
        if ($status !== null) {
            $parameters['status'] = (string) $status;
        }
        if ($text !== null) {
            $parameters['text'] = (string) $text;
        }
        if ($authorName !== null) {
            $parameters['authorName'] = (string) $authorName;
        }
        if ($authorEmail !== null) {
            $parameters['authorEmail'] = (string) $authorEmail;
        }
        if ($authorWebsite !== null) {
            $parameters['authorWebsite'] = (string) $authorWebsite;
        }

        // make the call
        $this->doCall('blog.comments.update', $parameters, 'POST');
    }

    /**
     * Update the status for multiple comments at once.
     *
     * @param array  $ids    The ids of the commen(s to update.
     * @param string $status The new status for the comment. Possible values are: published, moderation, spam.
     */
    public function blogCommentsUpdateStatus(array $ids, $status)
    {
        // build parameters
        $parameters['id'] = $ids;
        $parameters['status'] = (string) $status;

        // make the call
        $this->doCall('blog.comments.updateStatus', $parameters, 'POST');
    }
}

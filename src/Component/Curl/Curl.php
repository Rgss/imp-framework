<?php

namespace Imp\Framework\Component\Curl;

/**
 * Class Curl
 * @package Imp\Framework\Component\Curl
 */
class Curl
{

    /**
     * @var curl handle
     */
    protected $curl;

    /**
     * @var string
     */
    protected $protocol;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * @var int
     */
    protected $connectTimeout;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $proxy;

    /**
     * @var bool
     */
    protected $ignoreSSL = true;

    /**
     * @var int
     */
    protected $maxRedirs = 3;

    /**
     * @var bool
     */
    protected $noBody = false;

    /**
     * @var int
     */
    private $errno = 0;

    /**
     * @var string
     */
    private $error;


    /**
     * Curl constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->curl = curl_init($this->url = $url);
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return int
     */
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * @param int $connectTimeout
     */
    public function setConnectTimeout($connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param array $cookies
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param array $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @return bool
     */
    public function isIgnoreSSL()
    {
        return $this->ignoreSSL;
    }

    /**
     * @param bool $ignoreSSL
     */
    public function setIgnoreSSL($ignoreSSL)
    {
        $this->ignoreSSL = $ignoreSSL;
    }

    /**
     * @return int
     */
    public function getMaxRedirs()
    {
        return $this->maxRedirs;
    }

    /**
     * @param int $maxRedirs
     */
    public function setMaxRedirs($maxRedirs)
    {
        $this->maxRedirs = $maxRedirs;
    }

    /**
     * @return bool
     */
    public function isNoBody()
    {
        return $this->noBody;
    }

    /**
     * @param bool $noBody
     */
    public function setNoBody($noBody)
    {
        $this->noBody = $noBody;
    }


    /**
     * execute
     *
     * @param string $url
     * @param array $params
     * @param array $cookie
     * @param string $method
     * @param number $timeout
     * @param array $header
     * @param string $referer
     * @return mixed
     */
    public function execute($url, $params = array(), $cookie = array(), $method = 'GET', $timeout = 3000, $header = array(), $referer = null)
    {
        $this->handleOptions();

        $result = curl_exec($this->curl);

        $this->errno  = curl_errno($this->curl);
        if ($this->errno != 0) {
            $this->error  = curl_error($this->curl);
        }



        return $result;
    }

    /**
     * handleOptions
     */
    protected function handleOptions()
    {
        $this->buildDefaultOptions();

        if ($this->ignoreSSL) {
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        }

        foreach ($this->options as $key => $option) {
            curl_setopt($this->curl, $key, $option);
        }
    }

    /**
     * buildDefaultOptions
     */
    protected function buildDefaultOptions()
    {
        if (!isset($this->options[CURLOPT_HEADER])) {
            $this->options[CURLOPT_HEADER] = 0;
        }

        if (!isset($this->options[CURLOPT_TIMEOUT_MS])) {
            $this->options[CURLOPT_TIMEOUT_MS] = 1000;
        }

        if (!isset($this->options[CURLOPT_RETURNTRANSFER])) {
            $this->options[CURLOPT_RETURNTRANSFER] = true;
        }
    }

    /**
     * @return mixed
     */
    public function getCurlInfo() {
        return $res = curl_getinfo($this->curl);
    }

    /**
     * __destruct
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }
}
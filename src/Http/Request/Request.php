<?php

namespace Imp\Framework\Component\Http\Request;

use Imp\Framework\Component\Http\Url\Url;

/**
 * Class Request
 * @package Imp\Framework\Component\Http\Request
 */
class Request
{
    /**
     * @var
     */
    private $urlString;


    /**
     * @var Url
     */
    private $url;

    /**
     * @var
     */
    private $method;

    /**
     * @var
     */
    private $params;

    /**
     * @var array
     */
    private $headers = array();

    /**
     * @var array
     */
    private $cookies = array();


    /**
     * Request constructor.
     * @param string $url
     */
    public function __construct($urlString = '')
    {
        if (!$urlString) {
            $urlString = $this->getCurrentUrl();
        }
        $this->url = new Url($urlString);
        $this->params = array_merge($_GET, $_POST); // , $_COOKIE
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getHeader($key)
    {
        return array_key_exists($key, $this->headers) ? $this->headers[$key] : null;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getCookie($key)
    {
        return array_key_exists($key, $this->cookies) ? $this->cookies[$key] : null;
    }

    /**
     * @param $key
     * @param $cookie
     */
    public function setCookie($key, $cookie)
    {
        $this->cookies[$key] = $cookie;
    }

    /**
     *
     */
    public function getCurrentUrl()
    {
        if (empty($this->urlString)) {
            $this->urlString = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";
        }

        return $this->urlString;
    }

    /**
     * @return string
     */
    public function getRequestScheme()
    {
        return isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
    }

    public function getHost()
    {
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    }

    public function getPath()
    {
        return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
    }

    public function getQuery()
    {

    }

    /**
     * @return Url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param Url $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function setParam($key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getParam($key)
    {
        return array_key_exists($key, $this->params) ? $this->params[$key] : null;
    }

    /**
     * @param mixed $params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
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
     * @return string
     */
    public static function clientIp()
    {
        if (!empty($_SERVER ["HTTP_CDN_SRC_IP"])) {
            $ip = $_SERVER["HTTP_CDN_SRC_IP"];
        } else if (!empty($_SERVER ["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else if (!empty($_SERVER ["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER ["HTTP_X_FORWARDED_FOR"];
        } else if (!empty($_SERVER ["REMOTE_ADDR"])) {
            $ip = $_SERVER ["REMOTE_ADDR"];
        } else {
            $ip = "unknown";
        }

        return $ip;
    }
}
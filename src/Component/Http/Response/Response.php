<?php

namespace Imp\Framework\Component\Http\Response;

/**
 * Class Response
 * @package Mframework\Component\Http\Response
 */
class Response
{

    const HTTP_OK = 200;
    const HTTP_NOT_FOUND = 404;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;

    public static $statusTexts = array(
        200 => 'OK',
        301 => 'Moved Permanently',
        302 => 'Found',
        404 => 'Not Found',
    );

    /**
     * @var
     */
    private $headers = array();

    /**
     * @var
     */
    private $statusText;

    /**
     * @var
     */
    private $statusCode;

    /**
     * @var
     */
    private $body;

    /**
     * Response constructor.
     * @param $status
     * @param $body
     * @param array $headers
     */
    public function __construct($status, $body, $headers = array())
    {
        $this->setStatusCode($status);
        $this->setbody($body);
        $this->setHeaders($headers);
    }


    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        foreach ($headers as $key => $values) {
            $this->setHeader($key, $values);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusText()
    {
        return $this->statusText;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusText($statusCode)
    {
        $this->statusText = isset(self::$statusTexts[$statusCode]) ? self::$statusTexts[$statusCode] : '';
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getbody()
    {
        return $this->body;
    }

    /**
     * @param $body
     * @return $this
     */
    public function setbody($body)
    {
        $this->body = $body;
        return $this;
    }

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
     * @param $url
     */
    public function redirect($url)
    {
        ob_get_clean();
        header("Location: {$url}");
    }

}
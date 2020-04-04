<?php

namespace Imp\Framework\Component\Http\Url;

/**
 * Class Url
 * @package Imp\Framework\Component\Http\Url
 */
class Url
{

    /**
     * @var
     */
    private $schema;

    /**
     * @var
     */
    private $user;

    /**
     * @var
     */
    private $pass;

    /**
     * @var
     */
    private $host;

    /**
     * @var
     */
    private $port;

    /*
     *
     */
    private $path;

    /**
     * @var
     */
    private $query;

    /**
     * @var
     */
    private $fragment;

    /**
     * @var
     */
    private $url;

    /**
     * @var
     */
    private $fullUrl;

    /**
     * Url constructor.
     * @param $url
     */
    public function __construct($url)
    {
        $this->url = $url;

        $this->parse();
    }

    /**
     * parse url
     */
    public function parse()
    {
        $data = parse_url($this->url);
        $this->schema = isset($data["schema"]) ? $data["schema"] : null;
        $this->user = isset($data["user"]) ? $data["user"] : null;
        $this->pass = isset($data["pass"]) ? $data["pass"] : null;
        $this->host = isset($data["host"]) ? $data["host"] : null;
        $this->port = isset($data["port"]) ? $data["port"] : null;
        $this->path = isset($data["path"]) ? $data["path"] : null;
        $this->query = isset($data["query"]) ? $data["query"] : null;
        $this->fragment = isset($data["fragment"]) ? $data["fragment"] : null;
        $this->fullUrl = $this->buildFullUrl();
    }

    /**
     * @return string
     */
    public function buildFullUrl()
    {
        return $this->schema . '://' .
            $this->user . ":" .
            $this->pass . '@' .
            $this->host . ':' .
            $this->port .
            $this->path . '?' .
            $this->query . '#' .
            $this->fragment;
    }

    /**
     * @return mixed
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param mixed $schema
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @param mixed $fragment
     */
    public function setFragment($fragment)
    {
        $this->fragment = $fragment;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getFullUrl()
    {
        return $this->fullUrl;
    }

    /**
     * @param mixed $fullUrl
     */
    public function setFullUrl($fullUrl)
    {
        $this->fullUrl = $fullUrl;
    }


}
<?php

namespace Imp\Framework\Component\Http;

use Imp\Framework\Component\Curl\Curl;
use Imp\Framework\Component\Http\Response\Response;

/**
 * Class Http
 * @package Imp\Framework\Component\Http
 */
class Http extends Curl
{

    /**
     * get
     */
    const METHOD_GET = 'GET';

    /**
     * post
     */
    const METHOD_POST = 'POST';

    /**
     * put
     */
    const METHOD_PUT = 'PUT';

    /**
     * head
     */
    const METHOD_HEAD = 'HEAD';

    /**
     * options
     */
    const METHOD_OPTIONS = 'OPTIONS';


    /**
     * delete
     */
    const METHOD_DELETE = 'DELETE';

    /**
     * PATCH
     */
    const METHOD_PATCH = 'PATCH';

    /**
     * @var string
     */
    protected $protocol = 'http';

    /**
     * @var array
     */
    protected $cookies;

    /**
     * Http constructor.
     * @param $url
     */
    public function __construct($url)
    {
        parent::__construct($url);
    }

    /**
     * @param array $params
     * @return Response
     */
    public function get($params = array())
    {
        return $this->request(HTTP::METHOD_GET, $params);
    }

    /**
     * @param array $params
     * @return Response
     */
    public function post($params = array())
    {
        return $this->request(HTTP::METHOD_POST, $params);
    }

    /**
     * @param array $params
     * @return Response
     */
    public function head($params = array())
    {
        return $this->request(HTTP::METHOD_HEAD, $params);
    }

    /**
     * @param array $params
     * @return Response
     */
    public function delete($params = array())
    {
        return $this->request(HTTP::METHOD_DELETE, $params);
    }

    /**
     * @param array $params
     * @return Response
     */
    public function put($params = array())
    {
        return $this->request(HTTP::METHOD_PUT, $params);
    }

    /**
     * @param array $params
     * @return Response
     */
    public function patch($params = array())
    {
        return $this->request(HTTP::METHOD_PATCH, $params);
    }

    /**
     * @param array $params
     * @return Response
     */
    public function options($params = array())
    {
        return $this->request(HTTP::METHOD_OPTIONS, $params);
    }

    /**
     * request
     * @param $method
     * @param $params
     * @return Response
     */
    public function request($method, $params)
    {

        $this->handleHttpRequestOptions();

        $this->handleHttpMethodOptions($method, $params);

        $result = $this->execute($params);

        $curlInfo = $this->getCurlInfo();

        $responseHeader = substr($result, 0, $curlInfo['http_header_size']);
        $responseBody   = substr($result, $curlInfo['http_header_size']);

        $responseHeaders = $this->parseResponseHeader($responseHeader);

        $response = new Response($curlInfo['http_code'], $responseBody, $responseHeaders);

        return $response;
    }

    /**
     * @return mixed
     */
    public function getCurlInfo()
    {
        $info = parent::getCurlInfo();
        if (isset($info['header_size'])) {
            $info['http_header_size'] = $info['header_size'];
        }

        return $info;
    }

    /**
     * @param $responseHeader
     * @return array
     */
    public function parseResponseHeader($responseHeader)
    {
        $responseHeaders = array();
        $headers = explode("\r\n", $responseHeader);
        foreach ($headers as $k => $header) {
            $arr = explode(":", $header, 2);
            if (count($arr) <= 1) {
                $responseHeaders[] = $arr[0];
            } else {
                $responseHeaders[$arr[0]] = trim($arr[1]);
            }
        }

        return $responseHeaders;
    }

    /**
     * handleHttpRequestOptions
     */
    protected function handleHttpRequestOptions()
    {
        $this->options[CURLOPT_HEADER] = 1;
        $this->options[CURLINFO_HEADER_OUT] = true;
    }

    /**
     * handleHttpMethodOptions
     * @param $method
     * @param array $params
     */
    protected function handleHttpMethodOptions($method, $params = array())
    {
        switch ($method) {
            case HTTP::METHOD_GET:
                break;
            case HTTP::METHOD_POST:
                $this->options[CURLOPT_POST] = true;
                $this->options[CURLOPT_POSTFIELDS] = $params;
                break;
            case HTTP::METHOD_DELETE:
                $this->options[CURLOPT_CUSTOMREQUEST] = HTTP::METHOD_DELETE;
                break;
            case HTTP::METHOD_PUT:
                $this->options[CURLOPT_CUSTOMREQUEST] = HTTP::METHOD_PUT;
                break;
            case HTTP::METHOD_PATCH:
                $this->options[CURLOPT_CUSTOMREQUEST] = HTTP::METHOD_PATCH;
                break;
            case HTTP::METHOD_OPTIONS:
                $this->options[CURLOPT_CUSTOMREQUEST] = HTTP::METHOD_OPTIONS;
                break;
        }
    }

    /**
     * @param array $cookie
     */
    public function setCookies($cookie)
    {
        $value = '';
        foreach ($cookie as $k => $v) {
            $value .= $k . '=' . $v . ';';
        }

        $this->options[CURLOPT_COOKIE] = $value;
    }

    /**
     * setHeaders
     * @param array $headers
     */
    public function setHeaders($headers)
    {
        $value = array();
        foreach ($headers as $n => $v) {
            $value[] = $n . ':' . $v;
        }

        $this->options[CURLOPT_HTTPHEADER] = $value;
    }

    /**
     * setReferer
     * @param $referer
     */
    public function setReferer($referer)
    {
        $this->options[CURLOPT_REFERER] = $referer;
    }


    /**
     * 异步请求一个http地址
     *
     * @param string $url 请求的url
     * @param int $port 请求的服务器的端口
     * @param array $postarray 要使用post提交的一组值，默认为null，如果为null则使用get方式请求
     */
    public static function async1($url = '127.0.0.1', $port = 80, $postarray = null, $errno = '', $errstr = '', $timeout = 30)
    {
        $fp = fsockopen($url, $port, $errno, $errstr, $timeout);
        if (!$fp) {
            return;
        }
        $end = "\r\n";
        $method = empty($postarray) ? 'GET' : 'POST';
        $input = "$method /HTTP/1.0$end";
        $input .= "Host: $url$end";
        $input .= "Connection: Close$end";
        if ('POST' == $method) {
            $input .= "Content-Type: application/x-www-form-urlencoded$end";
            $first = true;
            $postval = '';
            foreach ($postarray as $key => $val) {
                if (!$first) {
                    $postval .= '&';
                } else {
                    $first = false;
                }
                $postval .= "$key=$val";
            }
            $input .= "Content-Length: " . strlen($postval) . $end;
        }
        //$input.="User-Agent: Mozilla/5.0 (Windows NT 5.2) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2$end";
        $input .= "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8$end";
        //$input.="Accept-Encoding: gzip,deflate,sdch$end";
        $input .= "$end";
        if ('POST' == $method) {
            $input .= "$postval$end";
        }
        fputs($fp, $input);
        fclose($fp);
    }


    /**
     * 发送异步http请求
     *
     * @param string $url
     * @param string $method
     * @param array $data
     * @param array $cookie
     * @param string $errno
     * @param string $errstr
     * @param number $timeout
     * @param string $response
     * @return Ambigous <boolean, Ambigous, string>
     */
    public static function asyncHttpRequest($url, $method = 'GET', $data = array(), $cookie = array(), &$errno = '', &$errstr = '', $timeout = 3, $response = false)
    {

        // no protocol
        if (!preg_match('/:\/\//i', $url)) {
            $url = 'http://' . $url;
        }

        $url_array = parse_url($url);
        if (empty($url_array['host'])) {
            die('url error.');
        }

        $host = $url_array['host'];
        $port = isset($url_array['port']) ? $url_array['port'] : 80;
        $path = !empty($url_array['path']) ? $url_array['path'] : '/';
        $query = !empty($url_array['query']) ? $url_array['query'] : '';

        return Http::httpRequest($host, $port, $method, $path . "?" . $query, $data, $cookie, $errno, $errstr, $timeout, $response);
    }


    /**
     * 发送http 请求
     *
     * @param string $host
     * @param number $port
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param array $cookie
     * @param string $errno
     * @param string $errstr
     * @param number $timeout
     * @param string $response
     * @return boolean|Ambigous <boolean, string>
     */
    public static function httpRequest($host, $port, $method = 'GET', $uri, $data, $cookie = array(), &$errno = '', &$errstr = '', $timeout = 30, $response = true)
    {

        $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
        if (!$fp) {
            return false;
        }

        $eof = "\r\n";
        $header = "{$method} {$uri}{$eof}";
        $header .= "HTTP/1.1" . $eof;
        $header .= "Host: " . $host . $eof; // HTTP 1.1 Host域不能省略

        /*
        $header .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13" . $eof;
        $header .= "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,q=0.5" . $eof;
        $header .= "Accept-Language: en-us,en;q=0.5" . $eof;
        $header .= "Accept-Encoding: gzip,deflate" . $eof;
        */

        // data
        if (strtoupper($method) == 'POST' && !empty($data)) {
            $post_str = '';
            foreach ($data as $k => $v) {
                $post_str .= $k . "=" . $v . "&";
            }
            $post_str = trim($post_str, '&');
            $header = 'Content-Type: application/x-www-form-urlencoded' . $eof;    //POST数据
            $header .= 'Content-Length: ' . strlen($post_str) . $eof . $eof;                //POST数据的长度
            $header .= $post_str . $eof;                                        //传递POST数据
        }

        // cookie
        if (!empty($cookie)) {
            $cookie_str = '';
            foreach ($cookie as $k => $v) {
                $cookie_str .= $k . "=" . $v . "; ";
            }
            $header = 'Cookie: ' . base64_encode($cookie_str) . $eof;
        }

        $header .= "Connection: Close" . $eof;
        fwrite($fp, $header);

        $ret = true;
        if ($response) {
            $ret = '';
            while ($line = fgets($fp)) {
                $ret .= $line;
            }
        }

        fclose($fp);

        return $ret;
    }


}



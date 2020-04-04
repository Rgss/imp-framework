<?php

namespace Imp\Framework;

/**
 * Class Result
 * @package Imp\Framework
 */
class Result
{

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $message;

    /**
     * @var mixed
     */
    private $data;

    /**
     * int
     */
    const SUCCESS_CODE = 200;

    /**
     * string
     */
    const SUCCESS_MESSAGE = "ok";

    /**
     * Result constructor.
     * @param $code
     * @param string $message
     */
    public function __construct($code, $message = "", $data = null)
    {
        $this->code    = $code;
        $this->message = $message;
        $this->data    = $data;
    }

    /**
     * isSuccess
     * @return bool
     */
    public function isSuccess() {
        if ($this->code == self::SUCCESS_CODE) {
            return true;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
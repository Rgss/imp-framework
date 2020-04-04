<?php

namespace Imp\Framework\Component\Database;

/**
 * Class Configure
 * @package Mframework\Component\Database
 */
class Configure
{
    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $type;

    /**
     * @var
     */
    private $drive;

    /**
     * @var
     */
    private $host;

    /**
     * @var
     */
    private $port;

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
    private $pconnect;

    /**
     * @var
     */
    private $dbName;

    /**
     * @var
     */
    private $charset;

    /**
     * @var
     */
    private $tablePrex;


    /**
     * Configure constructor.
     * @param $name
     * @param $type
     * @param $drive
     * @param $host
     * @param $port
     * @param $user
     * @param $pass
     * @param $pconnect
     * @param $dbName
     * @param $charset
     * @param $tablePrex
     */
    public function __construct($name, $type, $drive, $host, $port, $user, $pass, $pconnect, $dbName, $charset, $tablePrex)
    {
        $this->name = $name;
        $this->type = $type;
        $this->drive = $drive;
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        $this->pconnect = $pconnect;
        $this->dbName = $dbName;
        $this->charset = $charset;
        $this->tablePrex = $tablePrex;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDrive()
    {
        return $this->drive;
    }

    /**
     * @param mixed $drive
     */
    public function setDrive($drive)
    {
        $this->drive = $drive;
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
    public function getPconnect()
    {
        return $this->pconnect;
    }

    /**
     * @param mixed $pconnect
     */
    public function setPconnect($pconnect)
    {
        $this->pconnect = $pconnect;
    }

    /**
     * @return mixed
     */
    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * @param mixed $dbName
     */
    public function setDbName($dbName)
    {
        $this->dbName = $dbName;
    }

    /**
     * @return mixed
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param mixed $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * @return mixed
     */
    public function getTablePrex()
    {
        return $this->tablePrex;
    }

    /**
     * @param mixed $tablePrex
     */
    public function setTablePrex($tablePrex)
    {
        $this->tablePrex = $tablePrex;
    }

}

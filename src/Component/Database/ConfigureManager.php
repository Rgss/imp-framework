<?php

namespace Imp\Framework\Component\Database;

/**
 * Class ConfigureManager
 * @package Mframework\Component\Database
 */
class ConfigureManager
{

    /**
     * @var
     */
    private $path;

    /**
     * @var
     */
    private static $defaultPath;

    /**
     * @var
     */
    private static $configure;

    /**
     * @var
     */
    private static $configures;


    /**
     * Configure constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->initialize();
    }

    /**
     */
    public function initialize()
    {
        if (file_exists($this->path)) {
            $configs = require $this->path;
            foreach ($configs as $name => $config) {
                $name = isset($config['name']) ? $config['name'] : null;
                $type = isset($config['type']) ? $config['type'] : null;
                $drive = isset($config['drive']) ? $config['drive'] : null;
                $host = isset($config['host']) ? $config['host'] : null;
                $port = isset($config['port']) ? $config['port'] : null;
                $user = isset($config['user']) ? $config['user'] : null;
                $pass = isset($config['pass']) ? $config['pass'] : null;
                $pconnect = isset($config['pconnect']) ? $config['pconnect'] : null;
                $dbName = isset($config['dbName']) ? $config['dbName'] : null;
                $charset = isset($config['charset']) ? $config['charset'] : null;
                $tablePrex = isset($config['tablePrex']) ? $config['tablePrex'] : null;

                self::$configures[$name] = new Configure($name, $type, $drive, $host, $port, $user, $pass, $pconnect, $dbName, $charset, $tablePrex);
            }
        } else {
            self::$configures = $this->getDefaultConfigure();
        }


    }

    /**
     * @param $name
     * @return null
     */
    public function get($name)
    {
        return array_key_exists($name, self::$configures) ? self::$configures[$name] : self::$configures['default'];
    }

    /**
     * @return Configure
     */
    public function getDefaultConfigure()
    {
        $config = array(
            'type' => 'mysqli',
            'drive' => 'mysql',
            'host' => '127.0.0.1',
            'user' => 'root',
            'pass' => '',
            'pconnect' => 0,
            'port' => 3306,
            'dbName' => 'test',
            'charset' => 'utf8',
            'tablePrex' => '',
        );

        $configure = new Configure(
            'default',
            $config['type'],
            $config['drive'],
            $config['host'],
            $config['port'],
            $config['user'],
            $config['pass'],
            $config['pconnect'],
            $config['dbName'],
            $config['charset'],
            $config['tablePrex']);

        $configures['default'] = self::$configure;
        return $configures;
    }
}
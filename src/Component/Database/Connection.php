<?php

namespace Imp\Framework\Component\Database;

/**
 * Class Connection
 * @package Imp\Framework\Component\Database
 */
class Connection
{

    /**
     * $defaultDBName
     * @var string
     */
    protected static $defaultDBName = 'default';

    /**
     * $configFilePath
     * @var
     */
    protected static $configFilePath;

    /**
     * $connector
     * @var
     */
    protected static $connector;

    /**
     * $connectors
     * @var array
     */
    protected static $connectors = array();

    /**
     * @var
     */
    protected static $configureManager;

    /**
     * $activeRecord
     * @var ActiveRecord
     */
    protected $activeRecord = null;

    /**
     * @var
     */
    private $db;


    /**
     * @param null $name
     * @return Connection|mixed
     */
    public static function getConnector($name = null)
    {
        $config = self::getConfig($name);
        $dbID   = self::getDBId($config);

        if ($name != null && isset(self::$connectors[$dbID])) {
            return self::$connector = self::$connectors[$dbID];
        }

        if (self::$connector != null && $name == null) {
            return self::$connector;
        }

        if (self::$connector == null && $name == null) {
            $name = self::$defaultDBName;
        }

        self::$connector = new Connection();
        $driver = self::getDriver($config);
        self::$connector->db = new $driver($config);
        self::$connectors[$dbID] = self::$connector;

        return self::$connector;
    }

    /**
     * @param null $name
     * @return bool|mixed
     */
    public static function getConfig($name = null)
    {
        if (self::$configureManager == null) {
            self::$configureManager = new ConfigureManager(self::$configFilePath);
        }

        return self::$configureManager->get($name);
    }

    /**
     * @param null $model
     * @param null $alias
     * @return ActiveRecord
     */
    public function getActiveRecord($model = null, $alias = null)
    {
        if ($this->activeRecord === null || !empty($model)) {
            $this->activeRecord = new ActiveRecord(self::$connector->db, $model, $alias);
        }
        return $this->activeRecord;
    }

    /**
     * @return mixed
     */
    public function db()
    {
        return self::$connector->db;
    }

    /**
     * @param $config
     * @return string
     */
    public static function getDBId($config)
    {
        return $config->getHost() . $config->getPort() . $config->getDbName();
    }

    /**
     * @param $config
     * @return string
     */
    public static function getDriver($config)
    {
        $class = ucfirst($config->getType());
        return $drive = 'Mframework\Component\Database\\' . $class . '\\' . $class;
    }

    /**
     * @param $configPath
     */
    public static function setConfigPath($configPath)
    {
        self::$configFilePath = $configPath;
    }
}
<?php

namespace Imp\Framework\Component\Database;

/**
 * Class DB
 * @package Imp\Framework\Component\Database
 */
class DB
{

    /**
     * 初始化，唯一入口
     * @param $configPath
     */
    public static function initialize($configPath)
    {
        Connection::setConfigPath($configPath);
    }

    /**
     * instance
     *
     * @return string
     */
    public static function instance($dbName = null)
    {
        return Connection::getConnector($dbName);
    }

    /**
     * select table
     *
     * @param string $table
     */
    public static function table($table, $alias = null)
    {
        return Connection::getConnector()->getActiveRecord($table, $alias);
    }

    /**
     * database name
     *
     * @param string $name
     */
    public static function connection($name = null)
    {
        return Connection::getConnector($name);
    }

    /**
     * query sql
     *
     * @param string $sql
     */
    public static function query($sql)
    {
        return self::instance()->db()->query($sql);
    }

    /**
     * fetch one record
     *
     * @param string $sql
     */
    public static function fetch($sql = null)
    {
        return self::instance()->db()->fetch($sql);
    }

    /**
     * transaction
     *
     * @param function $callback
     */
    public static function transaction($callback, $params = array())
    {
        Connection::getConnector()->db()->beginTransaction();

        call_user_func_array($callback, $params);

        Connection::getConnector()->db()->commit();

//	    Connection::getConnector()->db()->rollback();
    }

    /**
     * start transaction
     *
     */
    public static function begin()
    {
        Connection::getConnector()->db()->beginTransaction();
    }

    /**
     * commit transaction
     *
     */
    public static function commit()
    {
        Connection::getConnector()->db()->commit();
    }

    /**
     * rollback
     *
     */
    public function rollback()
    {
        Connection::getConnector()->db()->rollback();
    }

}


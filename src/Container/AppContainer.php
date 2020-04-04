<?php

namespace Imp\Framework\Container;

/**
 * Class AppContainer
 * @package Imp\Framework\Container
 */
class AppContainer
{

    /**
     * @var
     */
    private static $application;

    /**
     * @var
     */
    private static $instance;


    /**
     * @param $application
     * @return static
     */
    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new static;
        }
        return self::$instance;
    }

    /**
     * @param $application
     */
    public static function newApplication($application)
    {
        self::$application = $application;
    }

    /**
     * @return mixed
     */
    public static function getApplication()
    {
        return self::$application;
    }

}
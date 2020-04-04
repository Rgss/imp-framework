<?php

namespace Imp\Framework;

/**
 * Class Kernel
 * @package Imp\Framework
 */
class Kernel
{

    /**
     * @var Kernel
     */
    private static $instance;

    /**
     * @var Application
     */
    private $application;

    /**
     * Kernel constructor.
     * @param Application $app
     */
    private function __construct()
    {
    }

    /**
     * Kernel constructor.
     * @param Application $app
     */
    public static function newApplication(Application $application)
    {
        self::instance();
        self::$instance->application = $application;
        return self::$instance;
    }

    /**
     * @return Kernel|static
     */
    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * boot
     */
    public function boot()
    {
        $this->application->run();
    }

    /**
     * terminate
     */
    public function terminate()
    {
    }

    /**
     * @return Application
     */
    public static function app()
    {
        return self::$instance->application;
    }

}
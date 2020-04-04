<?php

namespace Imp\Framework\Component\Configure;

/**
 * Class Configure
 * @package Imp\Framework\Component\Configure
 */
class Configure
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $configures = array();


    /**
     * Configure constructor.
     * @param $name
     * @param $configures
     */
    public function __construct($name, $configures)
    {
        $this->name      = $name;
        $this->configures = $configures;
    }

    /**
     * @param $name
     * @return null
     */
    public function get($name)
    {
        if (array_key_exists($name, $this->configures)) {
            $this->configures[$name];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getConfigure()
    {
        return $this->configure;
    }

    /**
     * @param array $configure
     */
    public function setConfigure($configure)
    {
        $this->configure = $configure;
    }


}
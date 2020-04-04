<?php

namespace Imp\Framework\Component\Mvc;

/**
 * Class Mvc
 * @package Imp\Framework\Component\Mvc
 */
class MvcResolver
{

    /**
     * @var
     */
    private $route;

    /**
     * @var
     */
    private $controllerManager;


    /**
     * Mvc constructor.
     * @param $route
     */
    public function __construct($route)
    {
        $this->route = $route;
    }

    /**
     * run
     */
    public function run() {
        $this->controllerManager = new ControllerResolver($this->route->getRouter(), $this->route->getRequest());
        $this->controllerManager->run();
    }
}
<?php

namespace Imp\Framework\Component\Mvc;

use Imp\Framework\Component\Route\Router;
use Imp\Framework\Kernel;

/**
 * Class ControllerManager
 * @package Imp\Framework\Component\Mvc
 */
class ControllerResolver
{
    /**
     * @var
     */
    private $request;

    /**
     * @var
     */
    private $router;

    /**
     * @var mixed
     */
    private $module;

    /**
     * @var mixed
     */
    private $controller;

    /**
     * @var mixed
     */
    private $action;

    /**
     * @var array|mixed
     */
    private $params = array();


    /**
     * ControllerManager constructor.
     * @param Router $router
     * @param $request
     */
    public function __construct(Router $router, $request)
    {
        $this->module = $router->getModule();
        $this->controller = $this->module;
        $this->action = $router->getAction();
        $this->params = $router->getParams();
        $this->request = $request;
    }

    /**
     * @param $module
     * @return string
     */
    public function genControllerName($module)
    {
        return $module . 'Controller';
    }

    /**
     * @param $module
     * @return string
     */
    public function genActionName($module)
    {
        return $module . 'Action';
    }

    /**
     * @return mixed
     */
    public function genNamespace()
    {
        return Kernel::app()->getName() . '\Controller\\';
    }

    /**
     * run
     */
    public function run()
    {
        $cNamespace = $this->genNamespace();
        $class = $cNamespace . ucfirst($this->genControllerName($this->controller));

        try {
            $controller = new $class;
            $controller->setRequest($this->request);
            $controller->setModule($this->module);

            $controller->beforeEvent();
            $this->callAction($controller, $this->genActionName($this->action), $this->params);
            $controller->afterEvent();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

    }

    /**
     * @param $controller
     * @param $action
     * @param $params
     */
    public function callAction(Controller $controller, $action, $params)
    {
        call_user_func_array(array($controller, $action), $params);
    }
}
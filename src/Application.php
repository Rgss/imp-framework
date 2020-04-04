<?php

namespace Imp\Framework;

use Imp\Framework\Component\Configure\Configure;
use Imp\Framework\Component\Configure\ConfigureResolver;
use Imp\Framework\Component\Http\Request\Request;

/**
 * Class Application
 * @package Imp\Framework
 */
class Application
{

    /**
     * @var
     */
    private $register;

    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $basePath;

    /**
     * @var Request
     */
    private $request;


    /**
     * Application constructor.
     */
    public function __construct($name, $path, $request)
    {
        $this->name     = $name;
        $this->basePath = $path;
        $this->request  = $request;
    }

    /**
     * @param $request
     */
    public function run()
    {
        $this->runRegister();

        $this->registerConfigure();

        $this->runDispatcher($this->request);
    }

    /**
     * @param $request
     */
    private function runDispatcher($request)
    {
        $dispatcher = new Dispatcher();

        $this->register->set('dispatcher', $dispatcher);

        $dispatcher->run($request);
    }

    /**
     * runRegister
     */
    private function runRegister()
    {
        $this->register = new Register();
    }

    /**
     * registerApplication
     */
    private function registerApplication()
    {
        $this->register->set('app', $this);
    }

    /**
     * registerConfigure
     */
    private function registerConfigure() {
        $resolver = new ConfigureResolver($this->basePath, $this->name);
        $resolver->initialize();

        $this->register->set('configure', $resolver);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getRegister()
    {
        return $this->register;
    }

    /**
     * register
     */
    public function register($name, $object)
    {
        $this->register->set($name, $object);
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param mixed $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }


}

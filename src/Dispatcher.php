<?php

namespace Imp\Framework;

use Imp\Framework\Component\Http\Request\Request;
use Imp\Framework\Component\Mvc\MvcResolver;
use Imp\Framework\Component\Route\RouterResolver;

class Dispatcher
{

    /**
     * @param Request $request
     */
    public function run($request) {
        $request = $this->handleRequest($request);

        Kernel::app()->register('request', $request);

        $route = $this->runRoute($request);

        $this->runMvc($route);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function handleRequest($request) {
        return $request;
    }

    /**
     * @param Request $request
     */
    public function runRoute($request) {
        $route = new RouterResolver($request);

        Kernel::app()->register('route', $route);

        return $route;
    }

    /**
     * @param $router
     */
    public function runMvc($route) {
        $mvc = new MvcResolver($route);

        Kernel::app()->register('mvc', $mvc);

        $mvc->run();
    }
}
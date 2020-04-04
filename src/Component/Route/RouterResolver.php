<?php

namespace Imp\Framework\Component\Route;

/**
 * Class Route
 * @package Imp\Framework\Component\Route
 */
class RouterResolver
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
     * @var
     */
    private $mode = 1;


    /**
     * Route constructor.
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
        $this->initialize($request);
    }

    /**
     * @param $request
     */
    public function initialize($request)
    {
        $data = $this->parser($request);
        $router = new Router($request);
        $router->setModule($data['module']);
        $router->setAction($data['action']);
        $router->setParams($data['params']);

        $this->router = $router;
    }

    /**
     * @param $request
     */
    public function parser($request)
    {

        switch ($this->mode) {
            case 2:
                $data = $this->_model_2($request);
                break;
            default:
                $data = $this->_model_1($request);
                break;
        }


        return $data;
    }

    /**
     * @param $request
     * @return array
     */
    private function _model_1($request)
    {
        $module = $request->getParam('c');
        $action = $request->getParam('a');
        $params = $request->getParams();

        return array(
            'module' => $module ? $module : 'home',
            'action' => $action ? $action : 'index',
            'params' => is_array($params) ? $params : array(),
        );
    }

    /**
     * @param $request
     */
    private function _model_2($request)
    {
        $url = $request->getCurrentUrl();
        $url = str_replace("//", '/', $url);
        $urlArr = parse_url($url);

        $scriptName = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
        $urlArr['path'] = str_replace($scriptName, '', $urlArr['path']);

        if (empty($urlArr['path']) || $urlArr['path'] == '/') {
            $module = 'home';
            $action = 'index';
            $param  = array();
        } else {
            $urlPath = trim($urlArr['path'], '/');
            $pathArr = explode('/', $urlPath);
            $module = isset($pathArr[0]) ? $pathArr[0] : 'home';
            $action = isset($pathArr[1]) ? $pathArr[1] : 'index';
            $param = array_slice($pathArr, 2);
            $param = array_merge($param, $request->getParams());
            $request->setParams($param);
        }

        return array(
            'module' => $module ? $module : 'home',
            'action' => $action ? $action : 'index',
            'params' => is_array($param) ? $param : array(),
        );
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param mixed $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    public function getRequest()
    {
        return $this->request;
    }
}
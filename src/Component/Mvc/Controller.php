<?php

namespace Imp\Framework\Component\Mvc;

use Imp\Framework\Component\Http\Request\Request;
use Imp\Framework\Component\Http\Response\Response;
use Imp\Framework\Component\Route\Router;

/**
 * Class Controller
 * @package Imp\Framework\Component\Mvc
 */
class Controller
{

    /**
     * @var
     */
    protected $request;

    /**
     * @var
     */
    protected $response;

    /**
     * @var
     */
    private $module;


    /**
     * @param $name
     * @param array $data
     * @param null $response
     */
    public function render($name, $data = array(), $response = null)
    {
        $vm = new ViewResolver($this, $name, $data);
        $vm->run();

//        if($response == null){
//            $response = new Response();
//        }
//
//        $response->setContent($vm);
//
//        return $response;

    }

    /**
     * beforeEvent
     */
    public function beforeEvent()
    {

    }

    /**
     * afterEvent
     */
    public function afterEvent()
    {

    }

    /**
     * @param $url
     * @param int $status
     * @return Response
     */
    public function redirect($url, $status = 200)
    {
        return new Response($url, $status);
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @param $data
     */
    public function json($data)
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     *
     */
    public function show_404()
    {
        $response = new Response();
        $response->setStatusCode(404);
        return $response;
        // return $response->redirect();
    }
}
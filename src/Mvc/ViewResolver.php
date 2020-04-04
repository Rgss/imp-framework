<?php

namespace Imp\Framework\Component\Mvc;

/**
 * Class ViewManager
 * @package Imp\Framework\Component\Mvc
 */
class ViewResolver
{
    /**
     * @var
     */
    private $controller;

    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $_basePath;

    /**
     * @var
     */
    private $data;


    /**
     * ViewManager constructor.
     * @param $controller
     * @param $name
     * @param $data
     */
    public function __construct($controller, $name, $data)
    {
        $this->controller = $controller;
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $view = new View();
        $view->beforeRender();
        $viewFile = $this->getRenderFile($this->name);
        if (!file_exists($viewFile)) {
            throw new \Exception("the file: [{$viewFile}] is not found.");
        }

        echo $this->renderPartial($viewFile, $this->data, true);
        $view->afterRender();
    }

    /**
     * @param $name
     * @return string
     */
    public function getRenderFile($name)
    {
        return $this->getRenderPath() . DIRECTORY_SEPARATOR . $this->getModule() . DIRECTORY_SEPARATOR . $name . '.php';
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        $crc = explode('\\', get_class($this->controller));
        $module = str_replace('Controller', '', $crc[2]);
        return $module;
    }

    /**
     * @return mixed
     */
    public function getRenderPath()
    {
        return $this->getBasePath() . DIRECTORY_SEPARATOR .'View';
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        $class = new \ReflectionClass(get_class($this->controller));
        $this->_basePath = dirname(dirname($class->getFileName()));
        return $this->_basePath;
    }

    /**
     * @param mixed $basePath
     */
    public function setBasePath($basePath)
    {
        $this->_basePath = $basePath;
    }


    /**
     * @param $viewFile
     * @param null $data
     * @param bool $return
     * @return string
     */
    public function renderPartial($viewFile, $data = null, $return = false)
    {
        if (is_array($data)) {
            extract($data, EXTR_PREFIX_SAME, 'data');
        } else {
            $data = $data;
        }

        if ($return) {
            ob_start();
            ob_implicit_flush(false);
            require $viewFile;
            return ob_get_clean();
        } else {
            try {
                require $viewFile;
            } catch (\Exception $e) {

            }
        }
    }

    /**
     * @param $name
     * @param null $data
     * @param bool $return
     * @return string
     */
    public function renderLayout($name, $data = null, $return = false)
    {
        $viewFile = $this->getRenderPath() . "/layouts/{$name}" . '.php';
        return $this->renderPartial($viewFile, $data, $return);
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }
}
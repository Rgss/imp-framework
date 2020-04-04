<?php

namespace Imp\Framework;

/**
 * Class Autoloader
 * @package Imp\Framework
 */
class Autoloader
{

    /**
     * autoload
     * @param $class
     */
    public static function autoload($class)
    {
        $res = explode('\\', $class);
        $module = array_shift($res);

        //echo "\r\nm: " . $module . ' class: ' . $class;
        if ($module == 'Imp') {
            $path = implode("/", $res);
            $path = dirname(__FILE__) . '/' . $path . '.php';
            if (file_exists($path)) {
                include $path;
            }
        } elseif ($module == 'common') {
            $path = implode("/", $res);
            $path = dirname(dirname(dirname(dirname(__FILE__)))) . '/src/common/' . $path . '.php';
            if (file_exists($path)) {
                include $path;
            }
        } else {
            $module  = lcfirst(Kernel::app()->getName());
            $appPath = lcfirst(Kernel::app()->getBasePath());
            $path    = lcfirst(implode("/", $res));
            $path    = $appPath  . '/src/'  . $module . '/' . $path . '.php';
//            echo $path;die();
            if (file_exists($path)) {
                include $path;
            }
        }
    }
}



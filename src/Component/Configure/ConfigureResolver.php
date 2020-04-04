<?php

namespace Imp\Framework\Component\Configure;

/**
 * Class ConfigureResolver
 * @package Imp\Framework\Component\Configure
 */
class ConfigureResolver
{

    /**
     * @var string
     */
    private $appName;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @var array
     */
    private $configures;


    /**
     * ConfigureResolver constructor.
     * @param $path
     * @param $name
     */
    public function __construct($path, $name)
    {
        $this->basePath = $path;
        $this->appName  = $name;
    }

    /**
     * initialize
     */
    public function initialize() {
        $this->scanfConfigure();
    }

    /**
     * scanfConfigure
     */
    public function scanfConfigure() {
        $path      = $this->basePath . DIRECTORY_SEPARATOR . 'src/' . $this->appName . DIRECTORY_SEPARATOR . 'config';
        $directory = new \RecursiveDirectoryIterator($path, \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS);
        $iterator  = new \RecursiveIteratorIterator($directory);
        foreach ($iterator as $file) {
            $name      = strtolower(str_replace("." . $file->getExtension(), "", $file->getBasename()));
            $configure = new Configure($name, include $file->getPathname());
            $this->configures[$name] = $configure;
        }
    }

    /**
     * @param $name
     * @return Configure|null
     */
    public function get($name)
    {
        if (!array_key_exists($name, $this->configures)) {
            return $this->configures[$name];
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function getAppPath()
    {
        return $this->appPath;
    }

    /**
     * @param mixed $appPath
     */
    public function setAppPath($appPath)
    {
        $this->appPath = $appPath;
    }

}
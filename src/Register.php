<?php
/**
 *  document
 *  ============================================================================
 *  Copyright (c) 2018 TO8TO Ltd.
 *  Web: http://www.to8to.com
 *  ============================================================================
 *  $Author: imp.zhang <[email address]>
 *  $Id: Register.php 2019/7/8 imp.zhang $
 */

namespace Imp\Framework;

/**
 * Class Register
 * @package Imp\Framework
 */
class Register
{

    /**
     * @var
     */
    private $container;


    /**
     * @param $key
     * @param $object
     */
    public function set($key, $object) {
        $this->container[$key] = $object;
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key) {
        return array_key_exists($key, $this->container) ? $this->container[$key] : null;
    }

}
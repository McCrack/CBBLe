<?php

namespace App\core\Traits;

trait PropertyContainer
{
    protected $container = [];

    public function init($container)
    {
        $this->container = $container;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->container[$key] ?? null;
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->container[$key] = $value;
    }

    /**
     * @param $key
     * @param $val
     * @return void
     */
    public function __set($key, $val)
    {
        $this->set($key, $val);
    }

    /**
     * @param $key
     * @return bool
     */
    public function exists($key)
    {
        return isset($this->container[$key]);
    }
    /**
     * @param $key
     * @return bool
     */
    public function missing($key)
    {
        return $this->exists($key)
            ? false
            : true;
    }

    /**
     * @param $key
     * @return void
     */
    public function delete($key)
    {
        if ($this->has($key)) {
            unset($this->container[$key]);
        }
    }

    /**
     * @param $container
     * @return void
     */
    public function mergeContainer($container)
    {
        foreach ($container as $key => $val) {
            $this->set($key, $val);
        }
    }
}

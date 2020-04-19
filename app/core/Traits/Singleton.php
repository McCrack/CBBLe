<?php

namespace App\core\Traits;

trait Singleton
{
    private static $instance = null;

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    private function __wakeup()
    {
    }

    /**
     * @return Singleton object
     */
    public static function getInstance()
    {
        return self::$instance ?? (self::$instance = new self());
    }
}

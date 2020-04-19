<?php

namespace App\core;

use Storage;

class Dictionary
{

    use Traits\Singleton;
    use Traits\PropertyContainer;

    private $lang;
    private $app;

    /**
     * @param $dictionaryName
     * @return array
     */
    public function make($dictionaryName, $lang, $app = "www")
    {
        $this->app = $app;
        $this->lang = $lang;
        $this->init($this->load($dictionaryName));
        return $this;
    }
    private function load($dictionaryName)
    {
        if (Storage::disk('dictionaries')->exists("{$this->app}/{$dictionaryName}/{$this->lang}.json")) {
            $json = Storage::disk('dictionaries')->get("{$this->app}/{$dictionaryName}/{$this->lang}.json");
            $container = json_decode($json, true);
        }
        return $container ?? [];
    }

    public function __call($name, $args)
    {
        return $this->exists($name)
            ? $this->{$name}->{$args[0]}
            : $this->add($name)->{$args[0]};
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key) ?? $key;
    }

    /**
     * @param $dictionaryName
     * @return object
     */
    public function merge($dictionaryName)
    {
        $container = $this->load($dictionaryName);
        $this->mergeContainer($container);
        return $this;
    }

    /**
     * @param $dictionaryName
     * @return object
     */
    public function add($dictionaryName)
    {
        $this->container[$dictionaryName] = new self();
        return $this->container[$dictionaryName]->make(
            $dictionaryName,
            $this->lang,
            $this->app
        );
    }
}

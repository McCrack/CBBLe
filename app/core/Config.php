<?php

namespace App\core;

class Config
{

	use Traits\Singleton;
	use Traits\PropertyContainer;

	/**
	 * @param $path
	 * @return object
	 */
	public function make($path)
	{
		$this->container = $this->load($path);
		return $this;
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * @param $path
	 * @return array
	 */
	private function load($path)
	{
		if (file_exists($path)) {
			$json = file_get_contents($path);
			$container = json_decode($json, true);
		}
		return $container ?? [];
	}

	public function join($path)
	{
		$container = $this->load($path);
		return $this->merge($container);
	}
	public function merge($container)
	{
		$this->mergeContainer($container);
		return $this;
	}

	public function addConfig($containerName, $path)
	{
		$this->container[$containerName] = new self();
		$this->container[$containerName]->make($path);
		return $this->container[$containerName];
	}

	public function add($containerName, $container)
	{
		$this->container[$containerName] = new self();
		$this->container[$containerName]->init($container);
		return $this->container[$containerName];
	}
}

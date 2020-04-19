<?php

namespace App\core;

class JSON
{
	/**
	 * @param STRING $path Path to file or php://input
	 *
	 * @return Array
	 */
	public static function load($path)
	{
		$json = file_get_contents($path);
		return json_decode($json, true);
	}
	/**
	 * @param STRING $path Path to file
	 * @param ARRAY $data
	 *
	 * @return INT
	 */
	public static function save($path, $data)
	{
		if (is_array($data) || is_object($data)) {
			$data = self::encode($data);
			return file_put_contents($path, $data);
		} else {
			return null;
		}
	}

	public static function parse($str, $assoc = true)
	{
		return json_decode($str, $assoc);
	}
	public static function encode($array)
	{
		return json_encode($array, JSON_UNESCAPED_UNICODE);
	}
	public static function stringify($value)
	{
		return $this->encode($array);
	}
}

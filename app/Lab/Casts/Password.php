<?php


namespace App\Lab\Casts;

use Hash;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Password implements CastsAttributes
{
	/**
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param string $key
	 * @param mixed $value
	 * @param array $attributes
	 * @return mixed|void
	 */
	public function get($model, string $key, $value, array $attributes)
	{
		return $value;
	}

	/**
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @param string $key
	 * @param mixed $value
	 * @param array $attributes
	 * @return array|string|void
	 */
	public function set($model, string $key, $value, array $attributes)
	{
		return Hash::make($value);
	}
}

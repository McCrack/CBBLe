<?php

namespace App\Lab\Models;

use App\Lab\Models\Interfaces\PatchModelInterface;

class User extends BaseModel implements PatchModelInterface
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'role', 'config'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
		'config' => 'array',
	];

	/**
	 * @param array $data
	 */
	public function patch(array $data): void
	{
		foreach ($data as $key => $val) {
			$this->{$key} = $val;
		}
		$this->save();
	}
}

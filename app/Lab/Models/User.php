<?php

namespace App\Lab\Models;

use App\Lab\Models\Interfaces\PatchModelInterface;
use App\Lab\Casts\Password;
use Illuminate\Support\Facades\Validator;


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
	 * @var array
	 */
	private array $rules = [
		'name' => 'string|max:64',
		'email' => 'email|string|max:64',
		'password' => 'min:8|string|confirmed',
		'role' => 'max:64|string',
		'config.language' => 'alpha|size:2',
		'config.theme' => 'string|max:16',
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
		'password' => Password::class,
	];

	/**
	 * @param array $data
	 */
	public function patch(array $data): void
	{
		$validator = Validator::make($data, $this->rules);
		foreach ($validator->valid() as $key => $val) {
			$this->{$key} = $val;
		}
		$this->save();
		$validator->validate();
	}
}

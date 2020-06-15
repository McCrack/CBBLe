<?php


namespace App\Lab;

use App\Lab\Repositories\Interfaces\SettingsRepositoryInterface;
use App\Lab\Repositories\Interfaces\UsersRepositoryInterface;

class ModelFactory
{
	/**
	 * @param string $modelName
	 * @param mixed $id|null
	 * @return mixed
	 */
	public static function make(string $modelName, $id = null)
	{
		switch ($modelName) {
			case "Settings":
				return app(SettingsRepositoryInterface::class)->getSettings($id);
				break;
			case "User":
				return app(UsersRepositoryInterface::class)->getUser($id);
				break;
			default:
				break;
		}
	}
}

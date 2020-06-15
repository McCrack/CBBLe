<?php


namespace App\Lab\Repositories\Interfaces;

use App\Lab\Models\User as Model;

interface UsersRepositoryInterface
{
	/**
	 * @param int $id
	 * @return Model
	 */
	public function getUser(int $id): Model;
}

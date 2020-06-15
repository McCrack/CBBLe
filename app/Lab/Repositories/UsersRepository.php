<?php


namespace App\Lab\Repositories;

use App\Lab\Repositories\Interfaces\UsersRepositoryInterface;
use App\Lab\Models\User as Model;

class UsersRepository extends CoreRepository implements UsersRepositoryInterface
{
	/**
	 * @param int $id
	 * @return Model
	 */
	public function getUser(int $id): Model
	{
		return $this->startConditions()->find($id);
	}

	/**
	 * @return string
	 */
	protected function getModelClass(): string
	{
		return Model::class;
	}
}

<?php

namespace App\Lab\Repositories;

use App\Lab\Repositories\Interfaces\SettingsRepositoryInterface;
use App\Lab\Models\Settings as Model;

class SettingsRepository extends CoreRepository implements SettingsRepositoryInterface
{
	/**
	 * @param string $configFileName
	 * @return Model
	 */
	public function getSettings(string $configFileName): Model
	{
		$model = $this->startConditions();
		$model->load($configFileName);
		return $model;
	}

	/**
	 * @return string
	 */
	public function getModelClass(): string
	{
		return Model::class;
	}
}

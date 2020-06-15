<?php

namespace App\Lab\Repositories\Interfaces;

use App\Lab\Models\Settings as Model;

interface SettingsRepositoryInterface
{
	/**
	 * @param string $configFileName
	 * @return mixed
	 */
	public function getSettings(string $configFileName): Model;
}

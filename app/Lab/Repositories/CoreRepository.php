<?php


namespace App\Lab\Repositories;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;

abstract class CoreRepository
{
	/**
	 * @var Model
	 */
	protected  $model;

	/**
	 * CoreRepository constructor.
	 */
	public function __construct()
	{
		$this->model = app($this->getModelClass());
	}

	/**
	 * @return mixed
	 */
	abstract protected function getModelClass();

	/**
	 * @return Model|Application|mixed
	 */
	protected function startConditions()
	{
		return clone $this->model;
	}
}

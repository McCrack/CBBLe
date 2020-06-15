<?php

namespace App\Providers;

use App\Lab\Repositories\SettingsRepository;
use App\Lab\Repositories\Interfaces\SettingsRepositoryInterface;
use App\Lab\Repositories\UsersRepository;
use App\Lab\Repositories\Interfaces\UsersRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->bind(
			SettingsRepositoryInterface::class,
			SettingsRepository::class
		);

		$this->app->bind(
			UsersRepositoryInterface::class,
			UsersRepository::class
		);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

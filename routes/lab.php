<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Routing\Router;

Auth::routes();

Route::middleware('auth:sanctum')->group(function(){
	Route::get('/routes', function(){
		return response()->json([
			'modules' => [
				'Dictionaries' => "translate",
				'Explorer' => "folder",
				'Materials' => "insert_drive_file",
				'Mediasets' => "collections",
				'Microdata' => "code",
				'Users' => "people_alt",
			],
			'extensions' => [
				'Sitemap' => '/sitemap',
				'Showcase' => "/showcase"
			],
		]);
	});
	Route::get('/settings', function(){
		return response()->json([
			'roles' => ["admin", "developer", "suspend"],
			'languages' => ["uk", "en", "ru"],
			'themes' => ["light"],
			'frontend' => [
				'site_name' => "C-BBLe",
				'email' => "info@c-bble.local",
				'logo' => "/logo.png",
				'language' => "en",
				'location' => "en",
				'languages' => [
					'uk' => "ua",
					'en' => "en",
					'ru' => "ru",
				],
				'phones' => [
					"(096) 521-6303",
					"(066) 717-0259",
				],
				'currency_rates' => [
					'UAH' => 1,
					'USD' => 25,
					'EUR' => 28,
				]
			],
			'global' => [
				'language' => "uk",
				'theme' => "light",
				'access' => [
					'Explorer' => ["admin", "developer"],
					'Users' => ["admin", "developer"],
					'Dictionaries' => ["admin", "developer"],
					'Materials' => ["admin", "developer"],
					'Mediasets' => ["admin", "developer"],
					'Microdata' => ["admin", "developer"],
				],
				'privileges' => [
					'Settings' => ["admin", "developer"],
					'Explorer' => [],
				],
			],
			'personal' => [
				'name' => "Eugene",
				'email' => "datamorg@gmail.com",
				'password' => "",
				'language' => "uk",
				'theme' => "light",
			]
		]);
	});
	Route::any('/{any?}', 'FrontendController@lab')
		->where('any', '^(?!api).*$');
});

Route::any('/', 'FrontendController@lab');

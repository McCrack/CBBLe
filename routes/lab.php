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
	Route::patch('/patch-controller', function(){
		throw new \Exception("It's not Ok", 500);
		return "It's Ok";
	});
	Route::get('/settings/personal', function(){
		return response()->json([
			'name' => "Eugene",
			'email' => "datamorg@gmail.com",
			'password' => "",
			'language' => "uk",
			'theme' => "light",
			'languages' => ["uk", "en", "ru"],
			'themes' => ["light"],
		]);
	});
	Route::get('/settings/global', function(){
		return response()->json([
			'language' => "uk",
			'theme' => "light",
			'languages' => ["uk", "en", "ru"],
			'themes' => ["light"],
			'roles' => ["admin", "developer", "suspend"],
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
		]);
	});
	Route::get('/settings/front-end', function(){
		return response()->json([
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
		]);
	});
	Route::any('/{any?}', 'FrontendController@lab')
		->where('any', '^(?!api).*$');
});

Route::any('/', 'FrontendController@lab');

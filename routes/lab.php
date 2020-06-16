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
	Route::patch('/patch-controller', 'PatchController');
	/*
	Route::get('/settings/personal', function(){
		return response()->json([
			'id' => 1,
			'name' => "Eugene",
			'email' => "datamorg@gmail.com",
			'password' => "",
			'language' => "uk",
			'theme' => "light",
			'languages' => ["uk", "en", "ru"],
			'themes' => ["light"],
		]);
	});
	*/
	Route::get('/settings/personal', 'SettingsController@personal');
	Route::get('/settings/lab', 'SettingsController@lab');
	Route::get('/settings/front-end', 'SettingsController@frontend');
	Route::any('/{any?}', 'FrontendController@lab')
		->where('any', '^(?!api).*$');
});

Route::any('/', 'FrontendController@lab');

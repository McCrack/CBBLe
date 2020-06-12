<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Routing\Router;

Auth::routes();

Route::any('/test', function(Router $router) {

	dd($router->currentRequest);
});

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth:sanctum')
	->get('/routes', function(){
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
Route::domain('lab.' . env('APP_DOMAIN'))
    ->middleware('auth:sanctum')
    ->any('/{any}', 'FrontendController@lab')
    ->where('any', '^(?!api).*$');

//Route::any('/{any}', 'FrontendController@app')->where('any', '^(?!api).*$');

Route::get('/home', 'HomeController@index')->name('home');

<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth:sanctum')
	->get('/routes', function(){
	return response()->json([
		'modules' => [
			'Users' =>"/users",
			'Explorer' =>"/explorer",
			'Materials' =>"/materials",
			'Mediasets' =>"/mediasets",
			'Microdata' =>"/microdata",
			'Dictionaries' =>"/dictionaries",
			'Settings' => "/settings"
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

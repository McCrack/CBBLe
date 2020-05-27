<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::domain('lab.' . getenv('APP_DOMAIN'))->group(function(){
    // For lab application
    Route::get('/{any}', 'FrontendController@lab')->where('any', '^(?!api).*$');
});
// For public application
Route::any('/{any}', 'FrontendController@app')->where('any', '^(?!api).*$');

<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Routing\Router;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

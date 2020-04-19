<?php

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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

AppConfig::getInstance()->make("../app/CBBLe/config.json");


Auth::routes();

Route::view('/', 'CBBLe/welcome');
Route::view('/welcome', 'CBBLe/welcome');

Route::group([
    'middleware' => ["auth"],
    'where'      => [
        'args'   => "(.*)",
        'module' => "Dictionaries|Users|Explorer|Materials|Mediaset|Settings"
    ]
], function () {
    Route::any('/{module}/{args?}', function (Request $request, $module, $args = null) {

        $config = AppConfig::getInstance();
        $config->merge(Auth::user()->config);

        View::share("config", $config);
        View::share("translate", Dictionary::getInstance()->make(
            "main",
            $config->language,
            "lab"
        ));

        return app($module)->{$request->method()}(
            $request,
            explode('/', $args)
        );
    })->middleware(['access']);
});

Route::group([
    'middleware' => ["auth", "IsExtension"],
    'where'      => ['args' => "(.*)"]
], function () {
    /** Extensions */
    Route::any('/{extension}/{method?}/{args?}', function (Request $request, $extension, $method = null, $args = null) {

        $config = AppConfig::getInstance();
        $config->merge(Auth::user()->config);
        View::share("config", $config);
        View::share("translate", Dictionary::getInstance()->make(
            "main",
            $config->language,
            "lab"
        ));
        View::share('extension', $extension);

        $controller = app("\App\CBBLe\Extensions\\{$extension}\\{$extension}");
        if ($method && method_exists($controller, $method)) {
            return $controller->{$method}($request);
        } else {
            return $controller->index($method);
        }
    })->middleware(['access']);
});

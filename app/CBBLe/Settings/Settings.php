<?php

namespace App\CBBLe\Settings;

use JSON;
use Auth;
use AppConfig;
use Illuminate\Http\Request;

use App\User;
use App\core\Dictionary;
use App\Http\Controllers\Controller;

class Settings extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request, $args)
    {
        $config = AppConfig::getInstance();

        $role = Auth::user()->role;

        $privileges = in_array($role, $config->Settings->privileges);

        $handle = time();
        $things = [
            'handle'        => "s-{$handle}",
            'caption'       => Dictionary::getInstance()->settings,
            'privileges'    => $privileges,
            'personal'      => Auth::user()->config,
            'global'        => JSON::load("../app/CBBLe/config.json"),
            'current'       => $args[0],
            'themes'        => array_map('pathinfo', glob('../public/css/themes/*.css'))
        ];
        if ($privileges) {
            $things['roles'] = User::select('role')->groupBy('role')->get();
            $things['site'] = JSON::load("../app/config.json");
            $things['extension'] = JSON::load("../app/CBBLe/Extensions/{$args[0]}/config.json");
        }
        return view('CBBLe.layouts.settings', $things);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public static function patch(Request $request, $args)
    {
        $config = AppConfig::getInstance();
        $saved = JSON::save("../app/config.json", $request->all());

        return ((int) $saved > 0)
            ? ['status' => "Success"]
            : ['status' => "Error"];
    }
    public static function post(Request $request, $args)
    {
        $config = JSON::load("../app/CBBLe/Extensions/{$args[0]}/config.json");
        $config[$request->name] = $request->value;
        $saved = JSON::save("../app/CBBLe/Extensions/{$args[0]}/config.json", $config);

        return ((int) $saved > 0)
            ? ['status' => "Success"]
            : ['status' => "Error"];
    }
    public static function put(Request $request, $args)
    {
        if ($args[0] == "global") {
            $config = JSON::load("../app/CBBLe/config.json");
            $config[$request->name] = $request->value;
            $saved = JSON::save("../app/CBBLe/config.json", $config);
        } elseif ($args[0] == "personal") {
            $config = Auth::user()->config;
            $config[$request->name] = $request->value;
            $saved = User::whereId(Auth::user()->id)->update([
                'config' => $config
            ]);
        }
        return ((int) $saved > 0)
            ? ['status' => "Success"]
            : ['status' => "Error"];
    }
}

<?php

namespace App\CBBLe\Dictionaries;

use Str;
use JSON;
use Storage;
use AppConfig;
use App\core\Dictionary;
use Illuminate\Http\Request;

class Dictionaries extends \App\Http\Controllers\Controller
{
    public static function checkAccess()
    {
        $config = AppConfig::getInstance();
        if ($config->missing('Dictionaries')) {
            $config->addConfig("Dictionaries", "../app/CBBLe/Dictionaries/config.json");
        }
        return in_array(\Auth::user()->role, $config->Dictionaries->access);
    }
    public static function index()
    {
        $tree = [];
        foreach (Storage::disk('dictionaries')->directories() as $app) {
            $tree[$app] = [];
            foreach (Storage::disk('dictionaries')->directories($app) as $dictionary) {
                $tree[$app][] = basename($dictionary);
            }
        }
        return $tree;
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request, $args)
    {
        $keys = [];
        $dictionary = [];
        foreach (Storage::disk('dictionaries')->files("{$args[1]}/{$args[0]}") as $path) {
            $lang = pathinfo($path)['filename'];
            $json = Storage::disk('dictionaries')->get($path);
            $dictionary[$lang] = json_decode($json, true);
            $keys = array_merge($keys, array_keys($dictionary[$lang]));
        }
        $keys = array_unique($keys);
        $handle = time();
        return view('CBBLe.layouts.dictionary', [
            'handle'        => "d-{$handle}",
            'caption'       => $args[0],
            'subdomain'     => $args[1],
            'keys'          => $keys,
            'dictionary'    => $dictionary
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, $args)
    {
        $config = AppConfig::getInstance();
        $response = [
            'status' => "Success",
            'message' => ""
        ];
        $name = Str::slug($request->name);
        if (Storage::disk('dictionaries')->missing("{$request->app}/{$request->name}")) {
            Storage::disk('dictionaries')->makeDirectory("{$request->app}/{$request->name}");
            foreach ($config->languages as $lang) {
                Storage::disk('dictionaries')->put("{$request->app}/{$request->name}/{$lang}.json", '{}');
            }
        } else {
            $dictionary = Dictionary::getInstance();
            $response = [
                'status' => "Error",
                'message' => $dictionary->{'dictionary'}
                    . " {$request->name} "
                    . $dictionary->alerts('already exists')
                    . "!"
            ];
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $args[0]
     * @param  string  $args[1]
     * @return \Illuminate\Http\Response
     */
    public static function put(Request $request, $args)
    {
        $response = [];
        foreach ($request->all() as $lang => $dictionary) {
            $response[$lang] = JSON::save("../storage/dictionaries/{$args[1]}/{$args[0]}/{$lang}.json", $dictionary) ?? 0;
        }
        return JSON::encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $args)
    {
        Storage::disk('dictionaries')->deleteDirectory("{$args[1]}/{$args[0]}");
    }
}

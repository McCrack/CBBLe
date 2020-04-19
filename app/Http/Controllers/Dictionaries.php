<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dictionaries extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd("Index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($dictionary, $subdomain)
    {
        dd($dictionary, $subdomain);
        $keys = [];
        $dictionary = [];
        foreach (glob("../../" . ARG_0 . "/storage/dictionaries/*/" . ARG_1 . ".json") as $path) {
            $lang = basename(dirname($path));
            $dictionary[$lang] = JSON::load($path);
            $keys = array_merge($keys, array_keys($dictionary[$lang]));
        }
        $keys = array_unique($keys);
        $handle = time();
        return view('layouts.dictionary', [
            'handle'        => "d-{$handle}",
            'caption'       => ARG_1,
            'subdomain'     => ARG_0,
            'keys'          => $keys,
            'dictionary'    => $dictionary
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

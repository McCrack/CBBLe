<?php

namespace App\CBBLe\Users;

use App\User;

use Validator;
use AppConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Users extends Controller
{
    public static function checkAccess()
    {
        $config = AppConfig::getInstance();
        if ($config->missing('Users')) {
            $config->addConfig("Users", "../app/CBBLe/Users/config.json");
        }
        return in_array(\Auth::user()->role, $config->Users->access);
    }
    public static function index()
    {
        $users = User::orderBy('role')->get();
        $team = [];
        $role = null;
        foreach ($users as $user) {
            if ($role != $user->role) {
                $role = $user->role;
                $team[$role] = [];
            }
            $team[$role][] = $user;
        }
        return $team;
    }

    /**
     * Display the specified resource.
     *
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request, $args)
    {
        $handle = time();
        if (empty($args[0])) {
            return view('CBBLe.layouts.user', [
                'handle'        => "u-{$handle}",
                'caption'       => "New User",
                'action'        => "create",
                'user'          => null
            ]);
        } else {
            $user = User::find($args[0]);
            return view('CBBLe.layouts.user', [
                'handle'        => "u-{$handle}",
                'caption'       => $user->name,
                'action'        => "save",
                'user'          => $user
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, $args)
    {
        $rules = [
            'role'      => "required|string|alpha_dash|max:24",
            'name'      => "required|string|alpha_dash|unique:users",
            'email'     => "required|email|unique:users,email",
            'password'  => "required|min:6"
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $user = new User;
            $user->role = $request->role;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->config = $request->config;
            $user->password = bcrypt($request->password);
            $saved = $user->save();

            $response = ['status' => ((int) $saved > 0) ? "Success" : "Error", 'errors' => []];
        } else {
            $response = [
                'status' => "Error",
                'errors' => $validator->errors()
            ];
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public static function put(Request $request, $args)
    {
        $rules = [
            'role'      => "required|string|alpha_dash",
            'name'      => "required|string|alpha_dash|unique:users,name,{$args[0]}",
            'email'     => "required|email|unique:users,email,{$args[0]}",
            'password'  => "sometimes"
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $data = [
                'role'  => $request->role,
                'name'  => $request->name,
                'email' => $request->email,
                'config' => $request->config
            ];
            if (isset($request->password)) {
                $data['password'] = bcrypt($request->password);
            }
            $saved = User::whereId($args[0])->update($data);
            $response = [
                'status' => ((int) $saved > 0) ? "Success" : "Error",
                'errors' => []
            ];
        } else {
            $response = [
                'status' => "Error",
                'errors' => $validator->errors()
            ];
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $args
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $args)
    {
        User::destroy($args[0]);
    }
}

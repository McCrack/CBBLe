<?php

namespace App\Http\Middleware;

use Closure;
use AppConfig;
use Validator;
use Illuminate\Support\Facades\Auth;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $config = AppConfig::getInstance();
        $module = $request->route()->parameter('extension');
        if (file_exists("../app/CBBLe/Extensions/{$module}/config.json")) {
            $config->addConfig($module, "../app/CBBLe/Extensions/{$module}/config.json");
        } else {
            $module = $request->route()->parameter('module');
            if (file_exists("../app/CBBLe/{$module}/config.json")) {
                $config->addConfig($module, "../app/CBBLe/{$module}/config.json");
            }
        }

        if (
            preg_match("/^(true|yes|on|1)$/", $config->{$module}->{'free access'}) ||
            in_array(Auth::user()->role, $config->{$module}->access)
        ) {
            return $next($request);
        }
        //return route('login');
        return redirect('/welcome');
    }
}

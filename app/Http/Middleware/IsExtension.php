<?php

namespace App\Http\Middleware;

use Closure;

class IsExtension
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
        $extension = $request->route()->parameter('extension');

        if (file_exists("../app/CBBLe/Extensions/{$extension}/config.json")) {
            return $next($request);
        }
        return redirect('/welcome');
    }
}

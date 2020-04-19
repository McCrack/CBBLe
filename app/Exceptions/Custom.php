<?php

namespace App\Exceptions;

use Exception;
use App\PageModel;

class Custom extends Exception
{

    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */

    public function render($request)
    {
        $page = PageModel::whereSlug("404")->first();
        return response()->view('404', [
            'page'            => $page
        ], 404);
    }
}

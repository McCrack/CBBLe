<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // For lab application
    public function lab()
    {
    	// TODO make Front-end controller
        return view('auth.login');
    }
}

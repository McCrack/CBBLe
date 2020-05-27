<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    // For lab application
    public function lab()
    {
        return view('lab');
    }
    // For public application
    public function app()
    {
        return view('app');
    }
}

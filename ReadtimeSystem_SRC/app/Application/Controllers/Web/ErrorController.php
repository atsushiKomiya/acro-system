<?php

namespace App\Application\Controllers\Web;

use Illuminate\Http\Request;

class ErrorController extends WebController
{
    public function index(Request $request)
    {
        return view('ERROR');
    }
}

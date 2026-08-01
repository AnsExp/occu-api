<?php

namespace App\Http\Controllers;

class SystemDashboard extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        return view('system.index');
    }
}

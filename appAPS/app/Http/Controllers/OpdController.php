<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:3'); // Apply middleware to only allow opd
    }

    public function dashboard()
    {
        return view('dashboard.opd'); // Assuming 'dashboard.opd' is the view name
    }
}

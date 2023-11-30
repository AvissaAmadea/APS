<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:1'); // Apply middleware to only allow superadmin
    }
    
    public function dashboard()
    {
        return view('dashboard.superadmin'); // Assuming 'dashboard.superadmin' is the view name
    }
}

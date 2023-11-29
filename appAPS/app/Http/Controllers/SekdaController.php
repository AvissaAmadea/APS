<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SekdaController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole:2'); // Apply middleware to only allow sekda
    }
    
    public function dashboard()
    {
        return view('sekda.dashboard'); // Assuming 'dashboard.sekda' is the view name
    }
}

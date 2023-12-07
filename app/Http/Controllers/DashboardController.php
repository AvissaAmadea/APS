<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if (Auth::user()->role_id == 1) {
            return view('dashboard.superadmin');
        } else if (Auth::user()->role_id == 2) {
            return view('dashboard.sekda');
        } else if (Auth::user()->role_id == 3) {
            return view('dashboard.opd');
        } else {
            return view('/login');
        }
    }
}

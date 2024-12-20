<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard() {
        // dd(Auth::user());
        // dd(Auth::user()->getPermissionsViaRoles()->toArray());

        return view('adminLTE.dashboard');
    }
}

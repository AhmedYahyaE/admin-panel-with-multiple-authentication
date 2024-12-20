<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index() {
        // dd(Auth::user()->getPermissionsViaRoles()->toArray(), Auth::user()->can('view projects'), Auth::user()->can('view projects'));

        if (!Auth::user()->can('view projects')) {
            return redirect()->route('dashboard')->with('error', 'You (regular user) do not have permission to view Projects.');
        }

        return view('adminLTE.projects');
    }
}

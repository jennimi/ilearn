<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Retrieve admin details via the authenticated user
        $adminDetails = Auth::user()->admin;

        return view('admin.dashboard', compact('adminDetails'));
    }
}

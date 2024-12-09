<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function index()
    {
        // Retrieve teacher details via the authenticated user
        $teacherDetails = Auth::user()->teacher;

        return view('teacher.dashboard', compact('teacherDetails'));
    }
}

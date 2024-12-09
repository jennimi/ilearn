<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        // Retrieve student details via the authenticated user
        $studentDetails = Auth::user()->student;

        return view('student.dashboard', compact('studentDetails'));
    }
}

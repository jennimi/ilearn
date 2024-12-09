<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Dashboard
Route::middleware(['auth'])->get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

// Teacher Dashboard
Route::middleware(['auth'])->get('/teacher/dashboard', function () {
    return view('teacher.dashboard');
})->name('teacher.dashboard');

// Student Dashboard
Route::middleware(['auth'])->get('/student/dashboard', function () {
    return view('student.dashboard');
})->name('student.dashboard');

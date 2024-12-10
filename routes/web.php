<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth'])->get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
Route::middleware(['auth'])->get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'showUserCreationForm'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'createUsers'])->name('admin.users.store');
});

use App\Http\Controllers\ClassroomController;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('classrooms', [ClassroomController::class, 'index'])->name('admin.classrooms.index');
    Route::get('classrooms/create', [ClassroomController::class, 'create'])->name('admin.classrooms.create');
    Route::post('classrooms', [ClassroomController::class, 'store'])->name('admin.classrooms.store');
    Route::get('classrooms/{id}', [ClassroomController::class, 'show'])->name('admin.classrooms.show');
    Route::get('classrooms/{id}/edit', [ClassroomController::class, 'edit'])->name('admin.classrooms.edit');
    Route::put('classrooms/{id}', [ClassroomController::class, 'update'])->name('admin.classrooms.update');
    Route::get('classrooms/{id}/add-students', [ClassroomController::class, 'addStudentsForm'])->name('admin.classrooms.addStudentsForm');
    Route::post('classrooms/{id}/add-students', [ClassroomController::class, 'addStudents'])->name('admin.classrooms.addStudents');
    Route::delete('classrooms/{id}/remove-students', [ClassroomController::class, 'removeStudents'])->name('admin.classrooms.removeStudents');
});

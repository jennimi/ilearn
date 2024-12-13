<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth'])->get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
Route::middleware(['auth'])->get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::post('discussions/{id}/comments', [DiscussionController::class, 'addComment'])->name('discussions.addComment');
    Route::get('discussions/{id}', [DiscussionController::class, 'show'])->name('discussions.show');
});

Route::middleware(['auth'])->prefix('teacher')->group(function () {
    Route::get('courses/{id}', [TeacherController::class, 'showCourse'])->name('teacher.courses.show');
    Route::get('courses/{id}/modules', [TeacherController::class, 'showCourseModules'])->name('teacher.courses.modules');
    Route::post('courses/{id}/modules', [TeacherController::class, 'storeModule'])->name('teacher.modules.store');
    Route::post('comments/{id}/reply', [CommentController::class, 'reply'])->name('teacher.comments.reply');
});

use App\Http\Controllers\ClassroomController;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('users/show', [AdminController::class, 'showUsers'])->name('admin.users.index');
    Route::get('users', [AdminController::class, 'showUserCreationForm'])->name('admin.users.create');
    Route::post('users', [AdminController::class, 'createUsers'])->name('admin.users.store');
    Route::get('classrooms', [ClassroomController::class, 'index'])->name('admin.classrooms.index');
    Route::get('classrooms/create', [ClassroomController::class, 'create'])->name('admin.classrooms.create');
    Route::post('classrooms', [ClassroomController::class, 'store'])->name('admin.classrooms.store');
    Route::get('classrooms/{id}', [ClassroomController::class, 'show'])->name('admin.classrooms.show');
    Route::get('classrooms/{id}/edit', [ClassroomController::class, 'edit'])->name('admin.classrooms.edit');
    Route::put('classrooms/{id}', [ClassroomController::class, 'update'])->name('admin.classrooms.update');
    Route::get('classrooms/{id}/add-students', [ClassroomController::class, 'addStudentsForm'])->name('admin.classrooms.addStudentsForm');
    Route::post('classrooms/{id}/add-students', [ClassroomController::class, 'addStudents'])->name('admin.classrooms.addStudents');
    Route::delete('classrooms/{id}/remove-students', [ClassroomController::class, 'removeStudents'])->name('admin.classrooms.removeStudents');
    Route::get('courses/create', [AdminController::class, 'showCourseCreationForm'])->name('admin.courses.create');
    Route::post('courses/store', [AdminController::class, 'storeCourse'])->name('admin.courses.store');
    Route::get('/courses', [AdminController::class, 'indexCourses'])->name('admin.courses.index');
    Route::get('/courses/{id}', [AdminController::class, 'showCourse'])->name('admin.courses.show');
    Route::get('/courses/{id}/edit', [AdminController::class, 'editCourse'])->name('admin.courses.edit');
    Route::put('/courses/{id}', [AdminController::class, 'updateCourse'])->name('admin.courses.update');
    Route::delete('/courses/{id}', [AdminController::class, 'destroyCourse'])->name('admin.courses.destroy');
});

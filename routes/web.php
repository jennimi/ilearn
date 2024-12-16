<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\QuestionController;

use App\Http\Controllers\GeminiController;

Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

Route::match(['GET', 'POST'], '/gemini', [GeminiController::class, 'askGemini'])->name('gemini.ask');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::middleware(['auth'])->get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
Route::middleware(['auth'])->get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::post('discussions/{id}/comments', [DiscussionController::class, 'addComment'])->name('discussions.addComment');
    Route::get('discussions/{id}', [DiscussionController::class, 'show'])->name('discussions.show');
    Route::post('discussions/{id}/comment', [DiscussionController::class, 'addComment'])->name('discussions.comment.store');
});

Route::middleware(['auth'])->prefix('student')->group(function () {
    Route::get('courses/{id}', [StudentController::class, 'showCourse'])->name('student.courses.show');
    Route::get('quizzes/{id}/take', [QuizController::class, 'takeQuiz'])->name('student.quizzes.take');
    Route::post('quizzes/{id}/submit', [QuizController::class, 'submitQuiz'])->name('student.quizzes.submit');
    Route::get('quizzes/{id}/start', [QuizController::class, 'startQuiz'])->name('student.quizzes.start');
    Route::post('quizzes/{id}/question/{questionId}', [QuizController::class, 'submitAnswer'])->name('student.quizzes.submitAnswer');
    Route::get('quizzes/{id}/start', [QuizController::class, 'startQuiz'])->name('student.quizzes.start');
    Route::get('quizzes/{quiz}/review', [QuizController::class, 'reviewQuiz'])->name('student.quizzes.review');
    Route::get('assignments/{id}', [AssignmentController::class, 'show'])->name('student.assignments.show');
    Route::post('assignments/{id}/submit', [AssignmentController::class, 'submit'])->name('student.assignments.submit');
    Route::get('classroom/{id}/ranking', [StudentController::class, 'getClassRanking'])->name('student.ranking');
});

Route::middleware(['auth'])->prefix('teacher')->group(function () {
    Route::get('courses/{id}', [TeacherController::class, 'showCourse'])->name('teacher.courses.show');
    Route::get('courses/{id}/modules', [TeacherController::class, 'showCourseModules'])->name('teacher.courses.modules');
    Route::post('courses/{id}/modules', [TeacherController::class, 'storeModule'])->name('teacher.modules.store');
    Route::post('comments/{id}/reply', [CommentController::class, 'reply'])->name('teacher.comments.reply');
    Route::post('modules/{module}/lessons', [LessonController::class, 'store'])->name('teacher.lessons.store');
    Route::put('lessons/{id}/update', [LessonController::class, 'update'])->name('teacher.lessons.update');
    Route::delete('lessons/{id}', [LessonController::class, 'destroy'])->name('teacher.lessons.destroy');
    Route::post('modules/{id}/quizzes', [QuizController::class, 'storeQuiz'])->name('teacher.quizzes.store');
    Route::get('modules/{id}/quizzes/create', [QuizController::class, 'createQuiz'])->name('teacher.quizzes.create');
    Route::get('quizzes/{id}', [QuizController::class, 'showQuiz'])->name('teacher.quizzes.show');
    Route::get('leaderboard', [TeacherController::class, 'leaderboard'])->name('teacher.leaderboard');
    Route::patch('quizzes/{id}/toggle-visibility', [QuizController::class, 'toggleVisibility'])->name('teacher.quizzes.toggleVisibility');
    Route::patch('assignments/{id}/toggle-visibility', [AssignmentController::class, 'toggleVisibility'])->name('teacher.assignments.toggleVisibility');
    Route::put('assignments/{id}', [AssignmentController::class, 'update'])->name('teacher.assignments.update');
    Route::delete('assignments/{id}', [AssignmentController::class, 'destroy'])->name('teacher.assignments.destroy');
    Route::get('assignments/{id}', [AssignmentController::class, 'teacherShow'])->name('teacher.assignments.show');
    Route::get('assignments/{id}/edit', [AssignmentController::class, 'edit'])->name('teacher.assignments.edit');
    Route::put('assignments/{id}', [AssignmentController::class, 'update'])->name('teacher.assignments.update');
    Route::get('submissions/{id}', [SubmissionController::class, 'show'])->name('teacher.submissions.show');
    Route::put('submissions/{id}/update', [SubmissionController::class, 'update'])->name('teacher.submissions.update');
    Route::post('modules/{id}/generate-quiz', [GeminiController::class, 'generateQuiz'])->name('teacher.quizzes.generate');
    Route::post('/modules/{id}/assignments', [AssignmentController::class, 'store'])->name('teacher.assignments.store');
    Route::get('quizzes/{id}/edit', [QuizController::class, 'edit'])->name('teacher.quizzes.edit');
    Route::put('quizzes/{id}', [QuizController::class, 'update'])->name('teacher.quizzes.update');
    Route::delete('quizzes/{id}', [QuizController::class, 'destroyQuiz'])->name('teacher.quizzes.destroy');
    Route::delete('questions/{id}', [QuestionController::class, 'destroy'])->name('teacher.questions.destroy');
    Route::put('questions/{id}', [QuestionController::class, 'update'])->name('teacher.questions.update');
});

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

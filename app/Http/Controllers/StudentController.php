<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Comment;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class StudentController extends Controller
{
    public function index()
    {

        $student = Auth::user()->student;

        $classroom = $student->classrooms()->orderBy('classroom_student.created_at', 'desc')->first();

        $dayOfWeek = now()->format('l');

        // Today's schedule
        $scheduleOfTheDay = $student->classrooms()
            ->with(['courses' => function ($query) use ($dayOfWeek) {
                $query->where('day', $dayOfWeek)
                    ->whereDate('end_date', '>=', now());
            }])
            ->get()
            ->pluck('courses')
            ->flatten();

        // Weekly schedule
        $weekSchedule = $student->classrooms()
            ->with(['courses' => function ($query) {
                $query->whereDate('end_date', '>=', now())
                    ->orderBy('day');
            }])
            ->get()
            ->pluck('courses')
            ->flatten();

        // All courses
        $allCourses = $student->classrooms()
            ->with('courses')
            ->get()
            ->pluck('courses')
            ->flatten();

        // Recent replies
        $recentReplies = Comment::with(['discussion', 'user'])
            ->whereHas('discussion', function ($query) use ($student) {
                $query->whereIn('module_id', $student->classrooms->pluck('id'));
            })
            ->whereHas('user', function ($query) {
                $query->where('role', 'teacher');
            })
            ->latest()
            ->limit(3)
            ->get();

        // Fetch quizzes with deadlines
        $quizzes = Quiz::whereHas('module.course.classrooms', function ($query) use ($student) {
            $query->whereIn('classrooms.id', $student->classrooms->pluck('id'));
        })
            ->where('deadline', '>=', now())
            ->get(['title', 'deadline', 'id', 'module_id'])
            ->map(function ($quiz) {
                return [
                    'type' => 'Quiz',
                    'title' => $quiz->title,
                    'deadline' => $quiz->deadline,
                    'link' => route('student.quizzes.take', $quiz->id),
                ];
            });

        // Fetch assignments with deadlines
        $assignments = Assignment::whereHas('module.course.classrooms', function ($query) use ($student) {
            $query->whereIn('classrooms.id', $student->classrooms->pluck('id'));
        })
            ->where('deadline', '>=', now())
            ->get(['title', 'deadline', 'id', 'module_id'])
            ->map(function ($assignment) {
                return [
                    'type' => 'Assignment',
                    'title' => $assignment->title,
                    'deadline' => $assignment->deadline,
                    'link' => route('student.assignments.show', $assignment->id),
                ];
            });

        // Combine and sort deadlines
        $deadlines = collect($quizzes)
            ->merge($assignments)
            ->sortBy('deadline')
            ->take(3);

        $recentCourseId = Cookie::get('recent_course');
        $recentCourse = $recentCourseId ? Course::find($recentCourseId) : null;

        // dd($weekEvents->toArray());
        return view('student.dashboard', compact('classroom', 'student', 'scheduleOfTheDay', 'weekSchedule', 'allCourses', 'recentReplies', 'deadlines', 'recentCourse'));
    }

    public function showCourse($courseId)
    {
        $student = Auth::user()->student;
        Cookie::queue('recent_course', $courseId, 7 * 24 * 60);
        $course = Course::with(['modules.lessons', 'modules.quizzes', 'teacher'])
            ->whereHas('classrooms', function ($query) use ($student) {
                $query->whereIn('classrooms.id', $student->classrooms->pluck('id')); // Specify 'classrooms.id' explicitly
            })
            ->where('courses.id', $courseId) // Explicitly specify 'courses.id'
            ->firstOrFail();

        return view('student.courses.show', compact('course'));
    }

    public function getClassRanking($classroomId)
    {
        $classroom = Classroom::with(['students.quizResults', 'students.submissions'])->findOrFail($classroomId);

        $totalQuizzes = Quiz::whereHas('module', function ($query) use ($classroomId) {
            $query->whereHas('course', function ($query) use ($classroomId) {
                $query->whereHas('classrooms', function ($query) use ($classroomId) {
                    $query->where('classrooms.id', $classroomId);
                });
            });
        })->count();

        $totalAssignments = Assignment::whereHas('module', function ($query) use ($classroomId) {
            $query->whereHas('course', function ($query) use ($classroomId) {
                $query->whereHas('classrooms', function ($query) use ($classroomId) {
                    $query->where('classrooms.id', $classroomId);
                });
            });
        })->count();

        $totalTasks = $totalQuizzes + $totalAssignments;

        $students = $classroom->students->map(function ($student) use ($totalTasks) {
            $completedQuizzes = $student->quizResults->count();
            $gradedAssignments = $student->submissions->whereNotNull('grade')->count();

            $completedTasks = $completedQuizzes + $gradedAssignments;

            $progressPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            return [
                'id' => $student->id,
                'name' => $student->name,
                'progress' => round($progressPercentage),
                'score' => $student->quizResults->sum('score') + $student->submissions->sum('grade'),
                'completedTasks' => $completedTasks,
            ];
        });

        $students = $students
            ->sortByDesc(function ($student) {
                return [$student['score'], $student['completedTasks']];
            })
            ->values();

        return view('student.ranking', compact('classroom', 'students'));
    }
}

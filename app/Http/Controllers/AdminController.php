<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Admin;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Module;
use App\Models\Course;

class AdminController extends Controller
{
    public function index()
    {
        $adminDetails = Auth::user()->admin;

        $classrooms = Classroom::latest()->take(3)->get();

        $courses = Course::latest()->take(3)->get();

        return view('admin.dashboard', compact('adminDetails', 'classrooms', 'courses'));
    }

    // Show Users
    public function showUsers(Request $request)
    {
        // Get the 'type' parameter from the request
        $type = $request->input('type', 'students'); // Default to 'students'
    
        // Fetch users based on the type
        if ($type === 'students') {
            $users = Student::paginate(6);
        } elseif ($type === 'teachers') {
            $users = Teacher::paginate(6);
        } else {
            $users = collect(); // Empty collection if type is invalid
        }
    
        // Pass the data to the view
        return view('admin.users_index', compact('users', 'type'));
    }
    
    // Create Users
    public function showUserCreationForm()
    {
        return view('admin.create-users');
    }

    public function createUsers(Request $request)
    {
        $role = $request->input('role');
        $users = $request->input('users');
        $errors = [];

        foreach ($users as $index => $userData) {
            try {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make($userData['password']),
                    'role' => $role,
                ]);

                if ($role === 'admin') {
                    Admin::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => $user->password,
                        'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
                    ]);
                } elseif ($role === 'teacher') {
                    Teacher::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => $user->password,
                        'phone_number' => $userData['phone_number'] ?? null,
                        'date_of_birth' => $userData['date_of_birth'] ?? null,
                        'admin_id' => $userData['admin_id'] ?? 1,
                        'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
                    ]);
                } elseif ($role === 'student') {
                    Student::create([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'password' => $user->password,
                        'nik' => $userData['nik'] ?? null,
                        'phone_number' => $userData['phone_number'] ?? null,
                        'date_of_birth' => $userData['date_of_birth'] ?? null,
                        'address' => $userData['address'] ?? null,
                        'enrollment_date' => $userData['enrollment_date'] ?? null,
                        'admin_id' => $userData['admin_id'] ?? 1,
                        'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
                    ]);
                }
            } catch (\Exception $e) {
                $errors[] = "Row $index: " . $e->getMessage();
            }
        }

        if (count($errors) > 0) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        return redirect()->route('admin.users.create')->with('success', 'Users created successfully!');
    }

    public function indexCourses()
    {
        $courses = Course::with(['teacher', 'classrooms'])->get();

        return view('admin.courses.index', compact('courses'));
    }


    public function showCourseCreationForm()
    {
        $teachers = Teacher::all(); // Fetch all teachers
        $classrooms = Classroom::all(); // Fetch all classrooms

        return view('admin.courses.create', compact('teachers', 'classrooms'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'teacher_id' => 'required|exists:teachers,id',
            'classrooms' => 'required|array',
            'classrooms.*' => 'exists:classrooms,id',
        ]);

        foreach ($request->input('classrooms') as $classroomId) {
            $request->validate([
                "schedule.$classroomId.day" => 'required|string',
                "schedule.$classroomId.start_time" => 'required|date_format:H:i',
                "schedule.$classroomId.end_time" => 'required|date_format:H:i|after:schedule.' . $classroomId . '.start_time',
            ]);
        }

        $course = Course::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'teacher_id' => $request->input('teacher_id'),
        ]);

        foreach ($request->input('classrooms') as $classroomId) {
            $course->classrooms()->attach($classroomId, [
                'day' => $request->input("schedule.$classroomId.day"),
                'start_time' => $request->input("schedule.$classroomId.start_time"),
                'end_time' => $request->input("schedule.$classroomId.end_time"),
            ]);
        }

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function showCourse($id)
    {
        $course = Course::with(['teacher', 'classrooms'])->findOrFail($id);

        return view('admin.courses.show', compact('course'));
    }

    public function editCourse($id)
    {
        $course = Course::with(['teacher', 'classrooms'])->findOrFail($id);
        $teachers = Teacher::all();
        $classrooms = Classroom::all();

        return view('admin.courses.edit', compact('course', 'teachers', 'classrooms'));
    }

    public function destroyCourse($id)
    {
        $course = Course::findOrFail($id);

        $course->classrooms()->detach();
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail( $id);

        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'start_date' => 'required|date',
        //     'end_date' => 'required|date|after_or_equal:start_date',
        //     'teacher_id' => 'required|exists:teachers,id',
        //     'classrooms' => 'required|array',
        //     'classrooms.*' => 'exists:classrooms,id',
        // ]);

        // foreach ($request->input('classrooms') as $classroomId) {
        //     $request->validate([
        //         "schedule.$classroomId.day" => 'required|string',
        //         "schedule.$classroomId.start_time" => 'required|date_format:H:i',
        //         "schedule.$classroomId.end_time" => 'required|date_format:H:i|after:schedule.' . $classroomId . '.start_time',
        //     ]);
        // }

        $course->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'teacher_id' => $request->input('teacher_id'),
        ]);

        if ($request->has('classrooms')) {
            $updatedClassrooms = [];
            foreach ($request->input('classrooms') as $classroomId) {
                $updatedClassrooms[$classroomId] = [
                    'day' => $request->input("schedule.$classroomId.day"),
                    'start_time' => $request->input("schedule.$classroomId.start_time"),
                    'end_time' => $request->input("schedule.$classroomId.end_time"),
                ];
            }
            $course->classrooms()->sync($updatedClassrooms);
        }

        return redirect()->route('admin.courses.show', $id)->with('success', 'Course updated successfully.');
    }
}

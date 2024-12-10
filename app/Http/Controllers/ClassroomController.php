<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Student;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::with('teacher')->get();
        return view('admin.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('admin.classrooms.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $adminDetails = Auth::user()->admin;

        $request->validate([
            'name' => 'required|string|max:255',
            'time_period' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        Classroom::create([
            'name' => $request->input('name'),
            'time_period' => $request->input('time_period'),
            'teacher_id' => $request->input('teacher_id'),
            'admin_id' => $adminDetails->id, // Assign admin_id based on the authenticated admin
        ]);

        return redirect()->route('admin.classrooms.index')->with('success', 'Classroom created successfully.');
    }

    public function show($id)
    {
        $classroom = Classroom::with('teacher', 'students')->findOrFail($id);

        return view('admin.classrooms.show', compact('classroom'));
    }

    public function edit($id)
    {
        $classroom = Classroom::with('teacher')->findOrFail($id);
        $teachers = Teacher::all();

        return view('admin.classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'time_period' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $classroom->update([
            'name' => $request->input('name'),
            'time_period' => $request->input('time_period'),
            'teacher_id' => $request->input('teacher_id'),
        ]);

        return redirect()->route('admin.classrooms.show', $id)->with('success', 'Classroom updated successfully.');
    }

    public function addStudentsForm($id)
    {
        $classroom = Classroom::with('students')->findOrFail($id);

        // Students not already in the classroom and not in the same time period
        $students = Student::whereDoesntHave('classrooms', function ($query) use ($classroom) {
            $query->where('time_period', $classroom->time_period);
        })->get();

        return view('admin.classrooms.add-students', compact('classroom', 'students'));
    }

    public function addStudents(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        $classroom->students()->syncWithoutDetaching($request->input('students'));

        return redirect()->route('admin.classrooms.show', $id)->with('success', 'Students added successfully.');
    }

    public function removeStudents(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);

        $request->validate([
            'students' => 'required|array',
            'students.*' => 'exists:students,id',
        ]);

        $classroom->students()->detach($request->input('students'));

        return redirect()->route('admin.classrooms.addStudentsForm', $id)->with('success', 'Students removed successfully.');
    }
}

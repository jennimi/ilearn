<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Admin;
use App\Models\Teacher;
use App\Models\Student;

class AdminController extends Controller
{
    public function index()
    {
        // Retrieve admin details via the authenticated user
        $adminDetails = Auth::user()->admin;

        return view('admin.dashboard', compact('adminDetails'));
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
}

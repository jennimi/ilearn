<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $admin1 = User::create([
            'name' => 'Admin One',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $admin2 = User::create([
            'name' => 'Admin Two',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        Admin::create([
            'name' => $admin1->name,
            'profile_picture' => '/images/admin1.jpg',
            'email' => $admin1->email,
            'password' => $admin1->password,
        ]);

        Admin::create([
            'name' => $admin2->name,
            'profile_picture' => '/images/admin2.jpg',
            'email' => $admin2->email,
            'password' => $admin2->password,
        ]);

        $teacher1 = User::create([
            'name' => 'Teacher One',
            'email' => 'teacher1@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        $teacher2 = User::create([
            'name' => 'Teacher Two',
            'email' => 'teacher2@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        Teacher::create([
            'name' => $teacher1->name,
            'profile_picture' => '/images/teacher1.jpg',
            'email' => $teacher1->email,
            'password' => $teacher1->password,
            'phone_number' => '1234567890',
            'date_of_birth' => '1985-01-01',
            'admin_id' => 1,
        ]);

        Teacher::create([
            'name' => $teacher2->name,
            'profile_picture' => '/images/teacher2.jpg',
            'email' => $teacher2->email,
            'password' => $teacher2->password,
            'phone_number' => '0987654321',
            'date_of_birth' => '1987-05-15',
            'admin_id' => 2,
        ]);

        Classroom::create([
            'name' => 'XIIA1',
            'time_period' => 2024,
            'teacher_id' => 1,
            'admin_id' => 1,
        ]);

        Classroom::create([
            'name' => 'XIIA3',
            'time_period' => 2024,
            'teacher_id' => 1,
            'admin_id' => 2,
        ]);

        Classroom::create([
            'name' => 'XIIA2',
            'time_period' => 2024,
            'teacher_id' => 1,
            'admin_id' => 1,
        ]);

        $student1 = User::create([
            'name' => 'Student One',
            'email' => 'student1@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student2 = User::create([
            'name' => 'Student Two',
            'email' => 'student2@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        Student::create([
            'name' => $student1->name,
            'nik' => '23455',
            'profile_picture' => '/images/student1.jpg',
            'email' => $student1->email,
            'password' => $student1->password,
            'phone_number' => '1122334455',
            'date_of_birth' => '2005-09-10',
            'address' => '123 Main Street',
            'enrollment_date' => '2022-01-10',
            'admin_id' => 1,
        ]);

        Student::create([
            'name' => $student2->name,
            'nik' => '2346',
            'profile_picture' => '/images/student2.jpg',
            'email' => $student2->email,
            'password' => $student2->password,
            'phone_number' => '5566778899',
            'date_of_birth' => '2006-11-20',
            'address' => '456 Elm Street',
            'enrollment_date' => '2022-08-15',
            'admin_id' => 2,
        ]);
    }
}

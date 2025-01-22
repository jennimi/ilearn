<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create Teachers
        $teacher1 = User::create([
            'name' => 'Justin M.',
            'email' => 'justinm@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        $teacher2 = User::create([
            'name' => 'Anastasia P.',
            'email' => 'anastasiap@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        $teacher3 = User::create([
            'name' => 'Evan T.',
            'email' => 'evant@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        Teacher::create([
            'name' => $teacher1->name,
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $teacher1->email,
            'password' => $teacher1->password,
            'phone_number' => '081366559592',
            'date_of_birth' => '1985-01-01',
            'admin_id' => 1,
        ]);

        Teacher::create([
            'name' => $teacher2->name,
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $teacher2->email,
            'password' => $teacher2->password,
            'phone_number' => '081236542564',
            'date_of_birth' => '1987-05-15',
            'admin_id' => 2,
        ]);

        Teacher::create([
            'name' => $teacher3->name,
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $teacher3->email,
            'password' => $teacher3->password,
            'phone_number' => '081236542564',
            'date_of_birth' => '1990-02-08',
            'admin_id' => 2,
        ]);
    }
}

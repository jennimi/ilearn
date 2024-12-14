<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\Comment;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\Lesson;
use App\Models\Assignment;
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
        // Create Admins
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

        // Create Teachers
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

        // Create Classrooms
        $classroom1 = Classroom::create([
            'name' => 'XIIA1',
            'time_period' => 2024,
            'teacher_id' => 1,
            'admin_id' => 1,
        ]);

        $classroom2 = Classroom::create([
            'name' => 'XIIA2',
            'time_period' => 2024,
            'teacher_id' => 1,
            'admin_id' => 1,
        ]);

        $classroom3 = Classroom::create([
            'name' => 'XIIA3',
            'time_period' => 2024,
            'teacher_id' => 1,
            'admin_id' => 2,
        ]);

        // Create Students
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

        // Create Courses
        $course1 = Course::create([
            'teacher_id' => 1,
            'title' => 'Mathematics',
            'description' => 'Advanced mathematics for senior high school.',
            'start_date' => '2024-01-01',
            'end_date' => '2025-06-30',
        ]);

        $course2 = Course::create([
            'teacher_id' => 2,
            'title' => 'Physics',
            'description' => 'Fundamentals of physics with practical examples.',
            'start_date' => '2024-01-01',
            'end_date' => '2025-06-30',
        ]);

        $course3 = Course::create([
            'teacher_id' => 1,
            'title' => 'Chemistry',
            'description' => 'Introduction to organic and inorganic chemistry.',
            'start_date' => '2024-01-01',
            'end_date' => '2025-06-30',
        ]);

        // Assign Courses to Classrooms with Schedules
        $classroom1->courses()->attach($course1->id, [
            'day' => 'Monday',
            'start_time' => '08:00:00',
            'end_time' => '09:30:00',
        ]);

        $classroom2->courses()->attach($course2->id, [
            'day' => 'Thursday',
            'start_time' => '10:00:00',
            'end_time' => '11:30:00',
        ]);

        $classroom3->courses()->attach($course3->id, [
            'day' => 'Wednesday',
            'start_time' => '09:00:00',
            'end_time' => '10:30:00',
        ]);

        $classroom1->students()->attach([1, 2]);
        $classroom2->students()->attach([1]);
        $classroom3->students()->attach([2]);

        $discussion1 = Discussion::create([
            'module_id' => 1, // Module ID
            'teacher_id' => 1, // Use valid teacher ID
            'title' => 'Discussion for Module 1',
        ]);

        // Add Comments to Discussions
        $comment1 = Comment::create([
            'user_id' => $student1->id, // Student One
            'discussion_id' => $discussion1->id,
            'comment' => 'Can you explain this topic in more detail?',
        ]);

        $comment2 = Comment::create([
            'user_id' => $student2->id, // Student Two
            'discussion_id' => $discussion1->id,
            'comment' => 'I found this part confusing as well!',
        ]);

        $comment3 = Comment::create([
            'user_id' => $student1->id, // Student One
            'discussion_id' => $discussion1->id,
            'comment' => 'Can you provide more examples for this topic?',
        ]);

        // Replies to Comments by Teacher
        Comment::create([
            'user_id' => $teacher1->id, // Teacher One
            'discussion_id' => $discussion1->id,
            'comment' => 'Sure, I will provide more details in tomorrow\'s lecture.',
            'parent_id' => $comment1->id, // Reply to comment1
        ]);

        Comment::create([
            'user_id' => $teacher1->id, // Teacher One
            'discussion_id' => $discussion1->id,
            'comment' => 'Good point! Let me explain further in the discussion board.',
            'parent_id' => $comment2->id, // Reply to comment2
        ]);

        Comment::create([
            'user_id' => $teacher2->id, // Teacher Two
            'discussion_id' => $discussion1->id,
            'comment' => 'I\'ll add more examples in the notes. Thanks for the suggestion!',
            'parent_id' => $comment3->id, // Reply to comment3
        ]);

        $lesson1 = Lesson::create([
            'title' => 'Introduction to Mathematics',
            'content' => 'math_intro.pdf', // Make sure to upload this PDF to your storage
            'module_id' => 1, // Module 1
            'visible' => true,
        ]);

        $lesson2 = Lesson::create([
            'title' => 'Advanced Calculus',
            'content' => 'advanced_calculus.pdf', // Make sure to upload this PDF to your storage
            'module_id' => 1, // Module 1
            'visible' => false,
        ]);

        // Add a Quiz to Module 1
        $quiz1 = Quiz::create([
            'title' => 'Mathematics Basics Quiz',
            'description' => 'Test your knowledge of basic mathematics concepts.',
            'module_id' => 1, // Module 1
            'deadline' => Carbon::now()->addDays(7),
        ]);

        // Add Questions to the Quiz
        $question1 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'What is 2 + 2?',
            'question_type' => '0', // Single Choice
            'points' => 5,
        ]);

        QuestionChoice::create([
            'question_id' => $question1->id,
            'choice_text' => '3',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question1->id,
            'choice_text' => '4',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question1->id,
            'choice_text' => '5',
            'is_correct' => false,
        ]);

        $question2 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Which of the following are prime numbers?',
            'question_type' => '1', // Multiple Choice
            'points' => 10,
        ]);

        QuestionChoice::create([
            'question_id' => $question2->id,
            'choice_text' => '2',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question2->id,
            'choice_text' => '4',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question2->id,
            'choice_text' => '5',
            'is_correct' => true,
        ]);

        $question3 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Explain the importance of mathematics in everyday life.',
            'question_type' => '2', // Short Answer
            'points' => 20,
        ]);

        QuestionChoice::create([
            'question_id' => $question3->id,
            'choice_text' => 'Not important',
            'is_correct' => true,
        ]);

        // Add Lessons to Module 2
        $lesson3 = Lesson::create([
            'title' => 'Introduction to Physics',
            'content' => 'physics_intro.pdf', // Make sure to upload this PDF to your storage
            'module_id' => 2, // Module 2
            'visible' => true,
        ]);

        $lesson4 = Lesson::create([
            'title' => 'Fundamentals of Motion',
            'content' => 'motion_basics.pdf', // Make sure to upload this PDF to your storage
            'module_id' => 2, // Module 2
            'visible' => false,
        ]);

        // Add a Quiz to Module 2
        $quiz2 = Quiz::create([
            'title' => 'Physics Fundamentals Quiz',
            'description' => 'Test your knowledge of basic physics concepts.',
            'module_id' => 2, // Module 2
            'deadline' => Carbon::now()->addDays(1),
            'duration' => 10
        ]);

        // Add Questions to the Quiz
        $question4 = Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'What is the speed of light in a vacuum?',
            'question_type' => '0', // Single Choice
            'points' => 5,
        ]);

        QuestionChoice::create([
            'question_id' => $question4->id,
            'choice_text' => '300,000 km/s',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question4->id,
            'choice_text' => '150,000 km/s',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question4->id,
            'choice_text' => '450,000 km/s',
            'is_correct' => false,
        ]);

        $question5 = Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'Which of the following are laws of motion?',
            'question_type' => '1', // Multiple Choice
            'points' => 10,
        ]);

        QuestionChoice::create([
            'question_id' => $question5->id,
            'choice_text' => 'Newton\'s First Law',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question5->id,
            'choice_text' => 'Ohm\'s Law',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question5->id,
            'choice_text' => 'Newton\'s Second Law',
            'is_correct' => true,
        ]);

        $question6 = Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'Explain the concept of inertia.',
            'question_type' => '2', // Short Answer
            'points' => 20,
        ]);

        QuestionChoice::create([
            'question_id' => $question6->id,
            'choice_text' => 'I dont want to',
            'is_correct' => true,
        ]);

        // Add assignments for Module 1
        $assignment1 = Assignment::create([
            'module_id' => 1,
            'title' => 'Linear Equations Assignment',
            'description' => 'Solve the given set of linear equations.',
            'deadline' => Carbon::now()->addDays(7), // Deadline 7 days from now
        ]);

        $assignment2 = Assignment::create([
            'module_id' => 2,
            'title' => 'Quadratic Equations Assignment',
            'description' => 'Complete the questions on quadratic equations.',
            'deadline' => Carbon::now()->addDays(10), // Deadline 10 days from now
        ]);

        // Add assignments for Module 2
        $assignment3 = Assignment::create([
            'module_id' => 1,
            'title' => 'Physics Lab Report',
            'description' => 'Submit your findings from the recent lab experiment.',
            'deadline' => Carbon::create(2024, 12, 31, 23, 59, 59), // Specific deadline
        ]);

        $assignment4 = Assignment::create([
            'module_id' => 2,
            'title' => 'Newton’s Laws Application',
            'description' => 'Explain real-life examples of Newton’s laws.',
            'deadline' => Carbon::now()->addDays(14), // Deadline 14 days from now
        ]);
    }
}

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
            'name' => 'Michael S.',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $admin2 = User::create([
            'name' => 'Olivia A.',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        Admin::create([
            'name' => $admin1->name,
            'profile_picture' => 'placeholder-profile.png',
            'email' => $admin1->email,
            'password' => $admin1->password,
        ]);

        Admin::create([
            'name' => $admin2->name,
            'profile_picture' => 'placeholder-profile.png',
            'email' => $admin2->email,
            'password' => $admin2->password,
        ]);

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
            'teacher_id' => 2,
            'admin_id' => 1,
        ]);

        $classroom3 = Classroom::create([
            'name' => 'XIIA3',
            'time_period' => 2024,
            'teacher_id' => 3,
            'admin_id' => 2,
        ]);

        // Create Students
        $student1 = User::create(attributes: [
            'name' => 'Jamir G.',
            'email' => 'jamirg@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student2 = User::create([
            'name' => 'Davin L.',
            'email' => 'davinl@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student3 = User::create([
            'name' => 'Karina B.',
            'email' => 'karinab@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student4 = User::create([
            'name' => 'Lomar W.',
            'email' => 'lomarw@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student5 = User::create([
            'name' => 'Dante H.',
            'email' => 'danteh@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student6 = User::create([
            'name' => 'Tanjung W.',
            'email' => 'tanjungw@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student7 = User::create([
            'name' => 'Sinte D.',
            'email' => 'sinted@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student8 = User::create([
            'name' => 'Ian E.',
            'email' => 'iane@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student9 = User::create([
            'name' => 'Bagus R.',
            'email' => 'bagusr@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        $student10 = User::create([
            'name' => 'Nathan D.',
            'email' => 'nathand@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        Student::create([
            'name' => $student1->name,
            'nik' => '12001',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student1->email,
            'password' => $student1->password,
            'phone_number' => '081265987542',
            'date_of_birth' => '2006-09-10',
            'address' => 'Jl. Raya Darmo No. 45, Kelurahan Darmo, Kecamatan Wonokromo, Surabaya, Jawa Timur 60241, Indonesia',
            'enrollment_date' => '2022-01-10',
            'admin_id' => 1,
        ]);

        Student::create([
            'name' => $student2->name,
            'nik' => '12002',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student2->email,
            'password' => $student2->password,
            'phone_number' => '081302147766',
            'date_of_birth' => '2006-11-20',
            'address' => 'Jl. Mayjen Sungkono No. 101, Kelurahan Dukuh Pakis, Kecamatan Dukuh Pakis, Surabaya, Jawa Timur 60225, Indonesia',
            'enrollment_date' => '2022-08-15',
            'admin_id' => 2,
        ]);

        Student::create([
            'name' => $student3->name,
            'nik' => '12003',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student3->email,
            'password' => $student3->password,
            'phone_number' => '081312345678',
            'date_of_birth' => '2006-01-15',
            'address' => 'Jl. Raya Rungkut No. 72, Kelurahan Rungkut Kidul, Kecamatan Rungkut, Surabaya, Jawa Timur 60293, Indonesia',
            'enrollment_date' => '2022-09-10',
            'admin_id' => 1,
        ]);

        Student::create([
            'name' => $student4->name,
            'nik' => '12004',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student4->email,
            'password' => $student4->password,
            'phone_number' => '081212345679',
            'date_of_birth' => '2006-02-22',
            'address' => 'Jl. Manyar Kertoarjo No. 88, Kelurahan Mojo, Kecamatan Gubeng, Surabaya, Jawa Timur 60285, Indonesia',
            'enrollment_date' => '2022-08-20',
            'admin_id' => 2,
        ]);

        Student::create([
            'name' => $student5->name,
            'nik' => '12005',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student5->email,
            'password' => $student5->password,
            'phone_number' => '081312987654',
            'date_of_birth' => '2006-03-15',
            'address' => 'Jl. Kapas Krampung No. 150, Kelurahan Tambakrejo, Kecamatan Simokerto, Surabaya, Jawa Timur 60141, Indonesia',
            'enrollment_date' => '2022-08-25',
            'admin_id' => 1,
        ]);

        Student::create([
            'name' => $student6->name,
            'nik' => '12006',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student6->email,
            'password' => $student6->password,
            'phone_number' => '081212876543',
            'date_of_birth' => '2006-04-10',
            'address' => 'Jl. Kertajaya Indah No. 19, Kelurahan Klampis Ngasem, Kecamatan Sukolilo, Surabaya, Jawa Timur 60117, Indonesia',
            'enrollment_date' => '2022-09-05',
            'admin_id' => 2,
        ]);

        Student::create([
            'name' => $student7->name,
            'nik' => '12007',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student7->email,
            'password' => $student7->password,
            'phone_number' => '081313456789',
            'date_of_birth' => '2006-05-28',
            'address' => 'Jl. Ahmad Yani No. 22, Kelurahan Gayungan, Kecamatan Gayungan, Surabaya, Jawa Timur 60235, Indonesia',
            'enrollment_date' => '2022-09-12',
            'admin_id' => 1,
        ]);

        Student::create([
            'name' => $student8->name,
            'nik' => '12008',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student8->email,
            'password' => $student8->password,
            'phone_number' => '081212999888',
            'date_of_birth' => '2006-06-14',
            'address' => 'Jl. Tunjungan No. 76, Kelurahan Genteng, Kecamatan Genteng, Surabaya, Jawa Timur 60275, Indonesia',
            'enrollment_date' => '2022-09-18',
            'admin_id' => 2,
        ]);

        Student::create([
            'name' => $student9->name,
            'nik' => '12009',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student9->email,
            'password' => $student9->password,
            'phone_number' => '081313333444',
            'date_of_birth' => '2006-07-05',
            'address' => 'Jl. Raya Darmo No. 45, Kelurahan Darmo, Kecamatan Wonokromo, Surabaya, Jawa Timur 60241, Indonesia',
            'enrollment_date' => '2022-08-30',
            'admin_id' => 1,
        ]);

        Student::create([
            'name' => $student10->name,
            'nik' => '12010',
            'profile_picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
            'email' => $student10->email,
            'password' => $student10->password,
            'phone_number' => '081212111222',
            'date_of_birth' => '2006-08-22',
            'address' => 'Jl. Kenjeran No. 105, Kelurahan Kapas Madya, Kecamatan Tambaksari, Surabaya, Jawa Timur 60136, Indonesia',
            'enrollment_date' => '2022-08-22',
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
            'teacher_id' => 3,
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

        $students = range(1, 10);

        $classroom1->students()->attach(array_slice($students, 0, 3));
        $classroom2->students()->attach(array_slice($students, 3, 4));
        $classroom3->students()->attach(array_slice($students, 7, 3));

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
            'user_id' => $teacher1->id, // Teacher Two
            'discussion_id' => $discussion1->id,
            'comment' => 'I\'ll add more examples in the notes. Thanks for the suggestion!',
            'parent_id' => $comment3->id, // Reply to comment3
        ]);

        $discussion2 = Discussion::create([
            'module_id' => 4, // Module 4
            'teacher_id' => 2, // Teacher ID for the Physics course
            'title' => 'Discussion for Module 1',
        ]);
        
        // Add Comments to the Discussion
        $comment4 = Comment::create([
            'user_id' => $student3->id, // Student Three
            'discussion_id' => $discussion2->id,
            'comment' => 'I didn’t quite understand the concept of force and motion. Could you explain it again?',
        ]);
        
        $comment5 = Comment::create([
            'user_id' => $student4->id, // Student Four
            'discussion_id' => $discussion2->id,
            'comment' => 'I also had some trouble with this topic. Can anyone provide additional resources?',
        ]);
        
        $comment6 = Comment::create([
            'user_id' => $student5->id, // Student Five
            'discussion_id' => $discussion2->id,
            'comment' => 'I think I understand it, but I’m not sure how to apply it in practical situations.',
        ]);
        
        // Replies to Comments by Teacher
        Comment::create([
            'user_id' => $teacher2->id, // Teacher Two for Physics
            'discussion_id' => $discussion2->id,
            'comment' => 'No problem! I will go over the topic in the next lecture and provide more detailed examples.',
            'parent_id' => $comment4->id, // Reply to comment4
        ]);
        
        Comment::create([
            'user_id' => $teacher2->id, // Teacher Two for Physics
            'discussion_id' => $discussion2->id,
            'comment' => 'I’ll share additional reading materials and videos for this topic to help you.',
            'parent_id' => $comment5->id, // Reply to comment5
        ]);
        
        Comment::create([
            'user_id' => $teacher2->id, // Teacher Two for Physics
            'discussion_id' => $discussion2->id,
            'comment' => 'Great! I’ll demonstrate some real-life examples during the next class to help clarify things.',
            'parent_id' => $comment6->id, // Reply to comment6
        ]);
        
        $discussion3 = Discussion::create([
            'module_id' => 7, // Module 7 for the Chemistry course
            'teacher_id' => 3, // Teacher ID for the Chemistry course
            'title' => 'Discussion for Module 1',
        ]);
        
        // Add Comments to the Discussion
        $comment7 = Comment::create([
            'user_id' => $student6->id, // Student Six
            'discussion_id' => $discussion3->id,
            'comment' => 'I’m having trouble understanding the reaction mechanisms. Could someone clarify?',
        ]);
        
        $comment8 = Comment::create([
            'user_id' => $student7->id, // Student Seven
            'discussion_id' => $discussion3->id,
            'comment' => 'The topic is a bit confusing to me as well. Any suggested reading to get a better grasp?',
        ]);
        
        $comment9 = Comment::create([
            'user_id' => $student8->id, // Student Eight
            'discussion_id' => $discussion3->id,
            'comment' => 'Can anyone explain how the principles of organic chemistry apply to everyday life?',
        ]);
        
        // Replies to Comments by Teacher
        Comment::create([
            'user_id' => $teacher3->id, // Teacher Three for Chemistry
            'discussion_id' => $discussion3->id,
            'comment' => 'Absolutely! I will explain the reaction mechanisms more thoroughly in the next class and provide examples.',
            'parent_id' => $comment7->id, // Reply to comment7
        ]);
        
        Comment::create([
            'user_id' => $teacher3->id, // Teacher Three for Chemistry
            'discussion_id' => $discussion3->id,
            'comment' => 'I’ll upload additional readings and videos on reaction mechanisms to help you understand better.',
            'parent_id' => $comment8->id, // Reply to comment8
        ]);
        
        Comment::create([
            'user_id' => $teacher3->id, // Teacher Three for Chemistry
            'discussion_id' => $discussion3->id,
            'comment' => 'That’s a great question! I will discuss real-world applications of organic chemistry in the next lecture.',
            'parent_id' => $comment9->id, // Reply to comment9
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
            'module_id' => 2, // Module 1
            'visible' => false,
        ]);

        // Add a Quiz to Module 1
        $quiz1 = Quiz::create([
            'title' => 'Mathematics Basics Quiz',
            'description' => 'Test your knowledge of basic mathematics concepts.',
            'module_id' => 1, // Module 1
            'deadline' => Carbon::now()->addDays(7),
            'duration' => 10
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
            'question_text' => 'What is the square root of 4?',
            'question_type' => '2', // Short Answer
            'points' => 20,
        ]);

        QuestionChoice::create([
            'question_id' => $question3->id,
            'choice_text' => '2',
            'is_correct' => true,
        ]);

        $question4 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'What is the result of square of 5?',
            'question_type' => '2', // Short Answer
            'points' => 20,
        ]);

        QuestionChoice::create([
            'question_id' => $question4->id,
            'choice_text' => '25',
            'is_correct' => true,
        ]);

        $question5 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Which of the following is a branch of Mathematic?',
            'question_type' => '0', // Single Choice
            'points' => 20,
        ]);

        QuestionChoice::create([
            'question_id' => $question5->id,
            'choice_text' => 'Inertia',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question5->id,
            'choice_text' => 'Calculus',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question5->id,
            'choice_text' => 'Atoms',
            'is_correct' => false,
        ]);

        // Add Lessons to Module 2
        $lesson3 = Lesson::create([
            'title' => 'Introduction to Physics',
            'content' => 'physics_intro.pdf', // Make sure to upload this PDF to your storage
            'module_id' => 4, // Module 2
            'visible' => true,
        ]);

        $lesson4 = Lesson::create([
            'title' => 'Fundamentals of Motion',
            'content' => 'motion_basics.pdf', // Make sure to upload this PDF to your storage
            'module_id' => 5, // Module 2
            'visible' => false,
        ]);

        // Add a Quiz to Module 2
        $quiz2 = Quiz::create([
            'title' => 'Physics Fundamentals Quiz',
            'description' => 'Test your knowledge of basic physics concepts.',
            'module_id' => 4, // Module 2
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

        $lesson5 = Lesson::create([
            'title' => 'Introduction to Organic Chemistry',
            'content' => 'organic_chem_intro.pdf', // Make sure to upload this PDF to your storage
            'module_id' => 7, // Assuming Module 1 is for Organic Chemistry
            'visible' => true,
        ]);

        $lesson6 = Lesson::create([
            'title' => 'Basics of Inorganic Chemistry',
            'content' => 'inorganic_chem_basics.pdf', // Make sure to upload this PDF to your storage
            'module_id' => 8, // Assuming Module 2 is for Inorganic Chemistry
            'visible' => true,
        ]);

        $quiz3 = Quiz::create([
            'title' => 'Introduction to Organic Chemistry Quiz',
            'description' => 'Test your knowledge of Organic Chemistry concepts.',
            'module_id' => 7, // Module 1 (Organic Chemistry)
            'deadline' => Carbon::now()->addDays(1),
            'duration' => 10,
        ]);

        // Add Questions to the Quiz
        $question7 = Question::create([
            'quiz_id' => $quiz3->id,
            'question_text' => 'What is the general formula for alkanes?',
            'question_type' => '0', // Single Choice
            'points' => 5,
        ]);

        QuestionChoice::create([
            'question_id' => $question7->id,
            'choice_text' => 'CnH2n+2',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question7->id,
            'choice_text' => 'CnH2n',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question7->id,
            'choice_text' => 'CnH2n-2',
            'is_correct' => false,
        ]);

        $question8 = Question::create([
            'quiz_id' => $quiz3->id,
            'question_text' => 'What type of bond is formed between two carbon atoms in an alkene?',
            'question_type' => '0', // Single Choice
            'points' => 5,
        ]);

        QuestionChoice::create([
            'question_id' => $question8->id,
            'choice_text' => 'Double bond',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question8->id,
            'choice_text' => 'Triple bond',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question8->id,
            'choice_text' => 'Quadruple bond',
            'is_correct' => false,
        ]);

        $question9 = Question::create([
            'quiz_id' => $quiz3->id,
            'question_text' => 'Which of the following is a characteristic of an aromatic compound?',
            'question_type' => '1', // Multiple Choice
            'points' => 5,
        ]);

        QuestionChoice::create([
            'question_id' => $question9->id,
            'choice_text' => 'It contains a benzene ring.',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question9->id,
            'choice_text' => 'It is soluble in water.',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question9->id,
            'choice_text' => 'It is a saturated compound.',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question9->id,
            'choice_text' => 'It undergoes only substitution reactions.',
            'is_correct' => false,
        ]);

        // Add assignments for Module 2
        $assignment3 = Assignment::create([
            'module_id' => 4,
            'title' => 'Physics Lab Report',
            'description' => 'Submit your findings from the recent lab experiment.',
            'deadline' => Carbon::create(2024, 12, 31, 23, 59, 59), // Specific deadline
        ]);

        $assignment4 = Assignment::create([
            'module_id' => 5,
            'title' => 'Newton’s Laws Application',
            'description' => 'Explain real-life examples of Newton’s laws.',
            'deadline' => Carbon::now()->addDays(14), // Deadline 14 days from now
        ]);

        $assignment5 = Assignment::create([
            'module_id' => 7, // Module 1 (Organic Chemistry)
            'title' => 'Organic Chemistry Reaction Mechanisms',
            'description' => 'Describe the mechanism of nucleophilic substitution reactions.',
            'deadline' => Carbon::create(2024, 12, 15, 23, 59, 59), // Specific deadline
        ]);

        $assignment6 = Assignment::create([
            'module_id' => 8, // Module 2 (Inorganic Chemistry)
            'title' => 'Periodic Table Trends',
            'description' => 'Analyze and explain the trends in atomic radius, ionization energy, and electronegativity across periods and groups.',
            'deadline' => Carbon::now()->addDays(21), // Deadline 21 days from now
        ]);
    }
}

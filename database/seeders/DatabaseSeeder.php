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
        // Membuat Kursus
        $course1 = Course::create([
            'teacher_id' => 1,
            'title' => 'Matematika',
            'description' => 'Matematika tingkat lanjut untuk SMA.',
            'start_date' => '2024-01-01',
            'end_date' => '2025-06-30',
            'image' => 'images/course/image1.jpeg',
        ]);

        $course2 = Course::create([
            'teacher_id' => 2,
            'title' => 'Fisika',
            'description' => 'Dasar-dasar fisika dengan contoh praktis.',
            'start_date' => '2024-01-01',
            'end_date' => '2025-06-30',
            'image' => 'images/course/image2.jpeg',
        ]);

        $course3 = Course::create([
            'teacher_id' => 3,
            'title' => 'Kimia',
            'description' => 'Pengantar kimia organik dan anorganik.',
            'start_date' => '2024-01-01',
            'end_date' => '2025-06-30',
            'image' => 'images/course/image3.jpeg',
        ]);

        // Menugaskan Kursus ke Kelas dengan Jadwal
        $classroom1->courses()->attach($course1->id, [
            'day' => 'Senin',
            'start_time' => '08:00:00',
            'end_time' => '09:30:00',
        ]);

        $classroom1->courses()->attach($course2->id, [
            'day' => 'Kamis',
            'start_time' => '10:00:00',
            'end_time' => '11:30:00',
        ]);

        $classroom1->courses()->attach($course3->id, [
            'day' => 'Rabu',
            'start_time' => '09:00:00',
            'end_time' => '10:30:00',
        ]);

        $students = range(1, 10);

        $classroom1->students()->attach(array_slice($students, 0, 3));
        $classroom2->students()->attach(array_slice($students, 3, 4));
        $classroom3->students()->attach(array_slice($students, 7, 3));

        $discussion1 = Discussion::create([
            'module_id' => 1,
            'teacher_id' => 1,
            'title' => 'Diskusi untuk Modul 1',
        ]);

        // Menambahkan Komentar ke Diskusi
        $comment1 = Comment::create([
            'user_id' => $student1->id,
            'discussion_id' => $discussion1->id,
            'comment' => 'Bisakah Anda menjelaskan topik ini lebih detail?',
        ]);

        $comment2 = Comment::create([
            'user_id' => $student2->id,
            'discussion_id' => $discussion1->id,
            'comment' => 'Bagian ini juga cukup membingungkan bagi saya!',
        ]);

        $comment3 = Comment::create([
            'user_id' => $student1->id,
            'discussion_id' => $discussion1->id,
            'comment' => 'Dapatkah Anda memberikan lebih banyak contoh untuk topik ini?',
        ]);

        // Balasan dari Guru
        Comment::create([
            'user_id' => $teacher1->id,
            'discussion_id' => $discussion1->id,
            'comment' => 'Tentu, saya akan memberikan penjelasan lebih rinci di kelas besok.',
            'parent_id' => $comment1->id,
        ]);

        Comment::create([
            'user_id' => $teacher1->id,
            'discussion_id' => $discussion1->id,
            'comment' => 'Poin yang bagus! Saya akan membahasnya lebih lanjut di diskusi.',
            'parent_id' => $comment2->id,
        ]);

        Comment::create([
            'user_id' => $teacher1->id,
            'discussion_id' => $discussion1->id,
            'comment' => 'Saya akan menambahkan lebih banyak contoh di materi. Terima kasih atas sarannya!',
            'parent_id' => $comment3->id,
        ]);

        $discussion2 = Discussion::create([
            'module_id' => 4,
            'teacher_id' => 2,
            'title' => 'Diskusi untuk Modul 1',
        ]);

        // Komentar di Diskusi
        $comment4 = Comment::create([
            'user_id' => $student3->id,
            'discussion_id' => $discussion2->id,
            'comment' => 'Saya kurang memahami konsep gaya dan gerak. Bisakah Anda menjelaskannya lagi?',
        ]);

        $comment5 = Comment::create([
            'user_id' => $student4->id,
            'discussion_id' => $discussion2->id,
            'comment' => 'Saya juga merasa kesulitan dengan topik ini. Adakah referensi tambahan yang bisa diberikan?',
        ]);

        $comment6 = Comment::create([
            'user_id' => $student5->id,
            'discussion_id' => $discussion2->id,
            'comment' => 'Saya pikir saya mengerti, tetapi saya tidak yakin bagaimana menerapkannya di kehidupan nyata.',
        ]);

        // Balasan dari Guru
        Comment::create([
            'user_id' => $teacher2->id,
            'discussion_id' => $discussion2->id,
            'comment' => 'Tentu saja! Saya akan membahasnya lagi di kelas berikutnya dengan contoh yang lebih rinci.',
            'parent_id' => $comment4->id,
        ]);

        Comment::create([
            'user_id' => $teacher2->id,
            'discussion_id' => $discussion2->id,
            'comment' => 'Saya akan membagikan materi tambahan dan video untuk membantu Anda.',
            'parent_id' => $comment5->id,
        ]);

        Comment::create([
            'user_id' => $teacher2->id,
            'discussion_id' => $discussion2->id,
            'comment' => 'Bagus! Saya akan menunjukkan beberapa contoh nyata di kelas berikutnya.',
            'parent_id' => $comment6->id,
        ]);

        $discussion3 = Discussion::create([
            'module_id' => 7,
            'teacher_id' => 3,
            'title' => 'Diskusi untuk Modul 1',
        ]);

        // Komentar di Diskusi
        $comment7 = Comment::create([
            'user_id' => $student6->id,
            'discussion_id' => $discussion3->id,
            'comment' => 'Saya kesulitan memahami mekanisme reaksi. Bisa dijelaskan lebih rinci?',
        ]);

        $comment8 = Comment::create([
            'user_id' => $student7->id,
            'discussion_id' => $discussion3->id,
            'comment' => 'Topik ini cukup membingungkan bagi saya. Adakah referensi tambahan?',
        ]);

        $comment9 = Comment::create([
            'user_id' => $student8->id,
            'discussion_id' => $discussion3->id,
            'comment' => 'Bagaimana penerapan kimia organik dalam kehidupan sehari-hari?',
        ]);

        // Balasan dari Guru
        Comment::create([
            'user_id' => $teacher3->id,
            'discussion_id' => $discussion3->id,
            'comment' => 'Tentu saja! Saya akan menjelaskan mekanisme reaksi lebih rinci di kelas berikutnya.',
            'parent_id' => $comment7->id,
        ]);

        Comment::create([
            'user_id' => $teacher3->id,
            'discussion_id' => $discussion3->id,
            'comment' => 'Saya akan unggah materi tambahan tentang mekanisme reaksi untuk membantu Anda.',
            'parent_id' => $comment8->id,
        ]);

        Comment::create([
            'user_id' => $teacher3->id,
            'discussion_id' => $discussion3->id,
            'comment' => 'Pertanyaan bagus! Saya akan membahas penerapan kimia organik dalam kehidupan sehari-hari.',
            'parent_id' => $comment9->id,
        ]);
        $lesson1 = Lesson::create([
            'title' => 'Pendahuluan ke Matematika',
            'content' => 'lessons\matematika.pdf', // Pastikan untuk mengunggah PDF ini ke penyimpanan Anda
            'module_id' => 1, // Modul 1
            'visible' => true,
        ]);

        $lesson2 = Lesson::create([
            'title' => 'Kalkulus Tingkat Lanjut',
            'content' => 'kalkulus_tingkat_lanjut.pdf', // Pastikan untuk mengunggah PDF ini ke penyimpanan Anda
            'module_id' => 2, // Modul 1
            'visible' => false,
        ]);

        // Tambahkan Kuis ke Modul 1
        $quiz1 = Quiz::create([
            'title' => 'Kuis Dasar Matematika',
            'description' => 'Uji pengetahuan Anda tentang konsep dasar matematika.',
            'module_id' => 1, // Modul 1
            'deadline' => Carbon::now()->addDays(7),
            'duration' => 10
        ]);

        // Tambahkan Pertanyaan ke Kuis
        $question1 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Berapa hasil dari 2 + 2?',
            'question_type' => '0', // Pilihan Tunggal
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
            'question_text' => 'Manakah dari berikut ini yang merupakan bilangan prima?',
            'question_type' => '1', // Pilihan Ganda
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
            'question_text' => 'Berapa akar kuadrat dari 4?',
            'question_type' => '2', // Jawaban Pendek
            'points' => 20,
        ]);

        QuestionChoice::create([
            'question_id' => $question3->id,
            'choice_text' => '2',
            'is_correct' => true,
        ]);

        $question4 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Berapa hasil kuadrat dari 5?',
            'question_type' => '2', // Jawaban Pendek
            'points' => 20,
        ]);

        QuestionChoice::create([
            'question_id' => $question4->id,
            'choice_text' => '25',
            'is_correct' => true,
        ]);

        $question5 = Question::create([
            'quiz_id' => $quiz1->id,
            'question_text' => 'Manakah dari berikut ini yang merupakan cabang matematika?',
            'question_type' => '0', // Pilihan Tunggal
            'points' => 20,
        ]);

        QuestionChoice::create([
            'question_id' => $question5->id,
            'choice_text' => 'Inersia',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question5->id,
            'choice_text' => 'Kalkulus',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question5->id,
            'choice_text' => 'Atom',
            'is_correct' => false,
        ]);

        // Tambahkan Pelajaran ke Modul 2
        $lesson3 = Lesson::create([
            'title' => 'Pendahuluan ke Fisika',
            'content' => 'fisika_pendahuluan.pdf', // Pastikan untuk mengunggah PDF ini ke penyimpanan Anda
            'module_id' => 4, // Modul 2
            'visible' => true,
        ]);

        $lesson4 = Lesson::create([
            'title' => 'Dasar-Dasar Gerak',
            'content' => 'gerak_dasar.pdf', // Pastikan untuk mengunggah PDF ini ke penyimpanan Anda
            'module_id' => 5, // Modul 2
            'visible' => false,
        ]);

        // Tambahkan Kuis ke Modul 2
        $quiz2 = Quiz::create([
            'title' => 'Kuis Dasar Fisika',
            'description' => 'Uji pengetahuan Anda tentang konsep dasar fisika.',
            'module_id' => 4, // Modul 2
            'deadline' => Carbon::now()->addDays(1),
            'duration' => 10
        ]);

        // Tambahkan Pertanyaan ke Kuis
        $question6 = Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'Berapa kecepatan cahaya di ruang hampa?',
            'question_type' => '0', // Pilihan Tunggal
            'points' => 5,
        ]);

        QuestionChoice::create([
            'question_id' => $question6->id,
            'choice_text' => '300.000 km/s',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question6->id,
            'choice_text' => '150.000 km/s',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question6->id,
            'choice_text' => '450.000 km/s',
            'is_correct' => false,
        ]);

        $question7 = Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'Manakah dari berikut ini yang merupakan hukum gerak?',
            'question_type' => '1', // Pilihan Ganda
            'points' => 10,
        ]);

        QuestionChoice::create([
            'question_id' => $question7->id,
            'choice_text' => 'Hukum Pertama Newton',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question7->id,
            'choice_text' => 'Hukum Ohm',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question7->id,
            'choice_text' => 'Hukum Kedua Newton',
            'is_correct' => true,
        ]);

        $question8 = Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'Jelaskan konsep inersia.',
            'question_type' => '2', // Jawaban Pendek
            'points' => 20,
        ]);

        // Tambahkan Tugas untuk Modul 1
        $assignment1 = Assignment::create([
            'module_id' => 1,
            'title' => 'Tugas Persamaan Linear',
            'description' => 'Selesaikan serangkaian persamaan linear yang diberikan.',
            'deadline' => Carbon::now()->addDays(7),
        ]);

        $assignment2 = Assignment::create([
            'module_id' => 2,
            'title' => 'Tugas Persamaan Kuadrat',
            'description' => 'Lengkapi soal-soal tentang persamaan kuadrat.',
            'deadline' => Carbon::now()->addDays(10),
        ]);
        $lesson5 = Lesson::create([
            'title' => 'Pendahuluan ke Kimia Organik',
            'content' => 'lessons\kimia.pdf', // Pastikan untuk mengunggah PDF ini ke penyimpanan Anda
            'module_id' => 7, // Asumsi Modul 1 adalah untuk Kimia Organik
            'visible' => true,
        ]);

        $lesson6 = Lesson::create([
            'title' => 'Dasar-Dasar Kimia Anorganik',
            'content' => 'dasar_kimia_anorganik.pdf', // Pastikan untuk mengunggah PDF ini ke penyimpanan Anda
            'module_id' => 8, // Asumsi Modul 2 adalah untuk Kimia Anorganik
            'visible' => true,
        ]);

        $quiz3 = Quiz::create([
            'title' => 'Kuis Pendahuluan ke Kimia Organik',
            'description' => 'Uji pengetahuan Anda tentang konsep Kimia Organik.',
            'module_id' => 7, // Modul 1 (Kimia Organik)
            'deadline' => Carbon::now()->addDays(1),
            'duration' => 10,
        ]);

        // Tambahkan Pertanyaan ke Kuis
        $question7 = Question::create([
            'quiz_id' => $quiz3->id,
            'question_text' => 'Apa rumus umum untuk alkana?',
            'question_type' => '0', // Pilihan Tunggal
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
            'question_text' => 'Jenis ikatan apa yang terbentuk antara dua atom karbon dalam alkena?',
            'question_type' => '0', // Pilihan Tunggal
            'points' => 5,
        ]);

        QuestionChoice::create([
            'question_id' => $question8->id,
            'choice_text' => 'Ikatan rangkap dua',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question8->id,
            'choice_text' => 'Ikatan rangkap tiga',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question8->id,
            'choice_text' => 'Ikatan rangkap empat',
            'is_correct' => false,
        ]);

        $question9 = Question::create([
            'quiz_id' => $quiz3->id,
            'question_text' => 'Manakah dari berikut ini yang merupakan karakteristik senyawa aromatik?',
            'question_type' => '1', // Pilihan Ganda
            'points' => 5,
        ]);

        QuestionChoice::create([
            'question_id' => $question9->id,
            'choice_text' => 'Mengandung cincin benzena.',
            'is_correct' => true,
        ]);

        QuestionChoice::create([
            'question_id' => $question9->id,
            'choice_text' => 'Larut dalam air.',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question9->id,
            'choice_text' => 'Merupakan senyawa jenuh.',
            'is_correct' => false,
        ]);

        QuestionChoice::create([
            'question_id' => $question9->id,
            'choice_text' => 'Hanya mengalami reaksi substitusi.',
            'is_correct' => false,
        ]);

        // Tambahkan Tugas untuk Modul 2
        $assignment3 = Assignment::create([
            'module_id' => 4,
            'title' => 'Laporan Praktikum Fisika',
            'description' => 'Kumpulkan hasil temuan Anda dari eksperimen laboratorium terbaru.',
            'deadline' => Carbon::create(2024, 12, 31, 23, 59, 59), // Tanggal batas waktu tertentu
        ]);

        $assignment4 = Assignment::create([
            'module_id' => 5,
            'title' => 'Aplikasi Hukum Newton',
            'description' => 'Jelaskan contoh nyata penerapan hukum Newton.',
            'deadline' => Carbon::now()->addDays(14), // Batas waktu 14 hari dari sekarang
        ]);

        $assignment5 = Assignment::create([
            'module_id' => 7, // Modul 1 (Kimia Organik)
            'title' => 'Mekanisme Reaksi Kimia Organik',
            'description' => 'Jelaskan mekanisme reaksi substitusi nukleofilik.',
            'deadline' => Carbon::create(2024, 12, 15, 23, 59, 59), // Tanggal batas waktu tertentu
        ]);

        $assignment6 = Assignment::create([
            'module_id' => 8, // Modul 2 (Kimia Anorganik)
            'title' => 'Tren Tabel Periodik',
            'description' => 'Analisis dan jelaskan tren dalam jari-jari atom, energi ionisasi, dan elektronegativitas di seluruh periode dan golongan.',
            'deadline' => Carbon::now()->addDays(21), // Batas waktu 21 hari dari sekarang
        ]);
    }
}

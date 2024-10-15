<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil total user accounts (menghitung user berdasarkan usertype yang valid)
        $totalUsers = User::count();

        // Ambil total courses dari database
        $totalCourses = Course::count();

        // Ambil ID admin yang sedang login
        $adminId = Auth::user()->id;

        // Ambil average score dari courses yang di-post oleh admin tertentu
        $averageScores = Course::where('admin_id', $adminId)
            ->with('scores') // Mengambil relasi scores
            ->get()
            ->map(function($course) {
                return [
                    'course' => $course->title,
                    'average_score' => $course->scores->avg('score') // Menghitung rata-rata nilai
                ];
            });

        // Ambil ukuran file course (misalnya video atau teks) untuk course yang di-post oleh admin tertentu
        $courseFiles = Course::where('admin_id', $adminId)->get()->map(function($course) {
            return [
                'course' => $course->title,
                'file_size' => $course->getFileSize() // Asumsikan kamu membuat metode ini di model Course untuk menghitung ukuran file
            ];
        });

        // Ambil data kursus untuk ditampilkan dalam list kursus admin
        $courses = Course::where('admin_id', $adminId)->paginate(3); // Ambil 3 courses sekaligus dan gunakan pagination

        // Kirimkan data ke view admin dashboard
        return view('admin.homeadmin', compact('totalUsers', 'totalCourses', 'averageScores', 'courseFiles', 'courses'));
    }
}

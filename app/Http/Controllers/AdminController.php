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
        // Mengambil total user accounts yang terdaftar (menghitung semua user)
        $totalUsers = User::count();

        // Mengambil total courses dari database
        $totalCourses = Course::count();

        // Ambil ID admin yang sedang login
        $adminId = Auth::user()->id;

        // Mengambil average score dari courses yang di-post oleh admin tertentu
        $averageScores = Course::where('admin_id', $adminId)
            ->with('scores') // Mengambil relasi scores untuk setiap course
            ->get()
            ->map(function($course) {
                return [
                    'course' => $course->title,
                    'average_score' => $course->scores->avg('score') // Menghitung rata-rata nilai untuk setiap course
                ];
            });

        // Mengambil ukuran file dari setiap course yang di-post oleh admin tertentu
        $courseFiles = Course::where('admin_id', $adminId)->get()->map(function($course) {
            return [
                'course' => $course->title,
                'file_size' => $course->getFileSize() // Menggunakan metode yang diasumsikan sudah ada untuk menghitung ukuran file
            ];
        });

        // Mengambil data courses yang di-post oleh admin saat ini dengan pagination
        $courses = Course::where('admin_id', $adminId)->paginate(4); // Mengambil 4 courses sekaligus untuk ditampilkan dengan pagination

        // Kirimkan data ke view admin dashboard
        return view('admin.home-admin', compact('totalUsers', 'totalCourses', 'averageScores', 'courseFiles', 'courses'));
    }
}

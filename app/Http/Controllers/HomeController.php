<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 3 kursus dari setiap kategori
        $trendingCourses = Course::where('category_id', 1)->paginate(3);
        $bestCoursesDeaf = Course::where('category_id', 2)->paginate(3);
        $visitedCourses = Course::where('category_id', 3)->paginate(3);

        // Cek apakah user login
        $isLoggedIn = Auth::check();

        // Kirimkan data kursus dan status login ke view
        return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses', 'isLoggedIn'));
    }
}

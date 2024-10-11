<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
{
    if (Auth::check()) { // Memeriksa apakah user login
        $usertype = Auth::user()->usertype; // Mengambil usertype

        // dd($usertype); // Debug untuk memeriksa nilai usertype

        if ($usertype == 'admin') {
            return view('admin.homeadmin'); // Admin diarahkan ke homeadmin
        } else {
            // Ambil 3 kursus dari setiap kategori
            $trendingCourses = Course::where('category_id', 1)->paginate(3);
            $bestCoursesDeaf = Course::where('category_id', 2)->paginate(3);
            $visitedCourses = Course::where('category_id', 3)->paginate(3);

            return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses'));
        }
    } else {
        return redirect()->route('login'); // Jika tidak login, arahkan ke login
    }
}

    
}

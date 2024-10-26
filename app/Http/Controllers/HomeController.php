<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // public function index()
    // {
    //     // Ambil 3 kursus dari setiap kategori
    //     $trendingCourses = Course::where('category_id', 1)->paginate(3);
    //     $bestCoursesDeaf = Course::where('category_id', 2)->paginate(3);
    //     $visitedCourses = Course::where('category_id', 3)->paginate(3);

    //     // Cek apakah user login
    //     $isLoggedIn = Auth::check();

    //     // Kirimkan data kursus dan status login ke view
    //     return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses', 'isLoggedIn'));
    // }

    public function index()
    {
        try {
            // Ambil 3 kursus dari setiap kategori
            $trendingCourses = Course::where('category_id', 1)->paginate(3);
            $bestCoursesDeaf = Course::where('category_id', 2)->paginate(3);
            $visitedCourses = Course::where('category_id', 3)->paginate(3);

            // Cek apakah user login
            $isLoggedIn = Auth::check();

            // Debug: Cek jumlah data yang diambil
            Log::info('Trending Courses count: ' . $trendingCourses->count());
            Log::info('Best Courses Deaf count: ' . $bestCoursesDeaf->count());
            Log::info('Visited Courses count: ' . $visitedCourses->count());

            // Kirimkan data kursus dan status login ke view
            return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses', 'isLoggedIn'));
        } catch (\Exception $e) {
            Log::error('Error in HomeController@index: ' . $e->getMessage());
            return view('home', [
                'trendingCourses' => collect([]),
                'bestCoursesDeaf' => collect([]),
                'visitedCourses' => collect([]),
                'isLoggedIn' => Auth::check()
            ]);
        }
    }

    public function showHome()
    {
        $trendingCourses = Course::where('category_id', 'trending')->paginate(3);
        $bestCoursesDeaf = Course::where('category_id', 'deaf')->paginate(3);
        $visitedCourses = Course::where('visited', true)->paginate(3);

        return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses'));
    }
}

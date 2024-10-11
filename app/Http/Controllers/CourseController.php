<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function showHome()
    {
        // Ambil data kursus dari database berdasarkan kategori
        $trendingCourses = Course::where('category', 'trending')->get();
        $bestCoursesDeaf = Course::where('category', 'deaf')->get();
        $visitedCourses = Course::where('visited', true)->get();

        // Kirim data kursus ke view
        return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses'));
    }
}

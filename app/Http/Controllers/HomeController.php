<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Ambil semua kategori beserta kursusnya secara relasi
            $categories = Category::with('courses')->get();

            // Debug: Log jumlah kategori
            Log::info('Categories count: ' . $categories->count());

            // Kirimkan data kategori ke view
            return view('home', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error in HomeController@index: ' . $e->getMessage());
            return view('home', [
                'categories' => collect([]),
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


    public function updateContrastMode(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->update(['high_contrast_mode' => $request->input('high_contrast_mode')]);
        }
    
        return response()->json(['message' => 'Contrast mode updated successfully']);
    }    
}

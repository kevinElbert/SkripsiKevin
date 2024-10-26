<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CourseController extends Controller
{
    // Method to display courses on the home page
    public function showHome()
    {
        $trendingCourses = Course::where('category_id', 'trending')->paginate(3);
        $bestCoursesDeaf = Course::where('category_id', 'deaf')->paginate(3);
        $visitedCourses = Course::where('visited', true)->paginate(3);

        return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses'));
    }

    // Method to show the form to create a new course
    public function create()
    {
        // Mengambil semua kategori dari tabel categories
        $categories = \App\Models\Category::all();

        return view('admin.create-course', compact('categories'));
    }

    // Method to store a newly created course
    public function store(Request $request)
    {

        // \Log::info('Request received in store method'); // Debugging log
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:20000', // Validasi video yang diunggah
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'category' => 'required|integer', // kategori sebagai integer
            'is_published' => 'required|boolean',
        ]);

        $validatedData['admin_id'] = Auth::user()->id; // Mengaitkan admin yang sedang login

        // Handle video upload
        if ($request->hasFile('video')) {
            // Upload video ke Cloudinary
            $uploadedVideoUrl = Cloudinary::uploadVideo($request->file('video')->getRealPath())->getSecurePath();
            if (!$uploadedVideoUrl) {
                return redirect()->back()->with('error', 'Video upload failed');
            }
            $validatedData['video'] = $uploadedVideoUrl;
        }

        // Handle image upload (if image is uploaded)
        if ($request->hasFile('image')) {
            // Upload gambar ke Cloudinary
            $uploadedImageUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            if (!$uploadedImageUrl) {
                return redirect()->back()->with('error', 'Image upload failed');
            }
            $validatedData['image'] = $uploadedImageUrl;
        }
        
        // Pastikan category_id disertakan
        $validatedData['category_id'] = $request->input('category');

        // Simpan data ke database
        Course::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Course created successfully!');
    }

    // Method to show the form to edit an existing course
    public function edit($id)
    {
        $course = Course::findOrFail($id);

        // Mengambil kategori untuk dropdown di form edit
        $categories = \App\Models\Category::all();

        // Return ke halaman edit course (ganti view sesuai nama view edit course Anda)
        return view('admin.edit-course', compact('course', 'categories'));
    }

    // Method to update an existing course
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi gambar
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000', // Validasi video
            'category' => 'required|integer', // kategori sebagai integer
            'is_published' => 'required|boolean',
        ]);

        // Handle image upload (if image is uploaded)
        if ($request->hasFile('image')) {
            $uploadedImageUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            if (!$uploadedImageUrl) {
                return redirect()->back()->with('error', 'Image upload failed');
            }
            $validatedData['image'] = $uploadedImageUrl;
        }

        // Handle video upload (if video is uploaded)
        if ($request->hasFile('video')) {
            $uploadedVideoUrl = Cloudinary::uploadVideo($request->file('video')->getRealPath())->getSecurePath();
            if (!$uploadedVideoUrl) {
                return redirect()->back()->with('error', 'Video upload failed');
            }
            $validatedData['video'] = $uploadedVideoUrl;
        }

        // Update course dengan data yang sudah divalidasi
        $course->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Course updated successfully!');
    }

    // Method to delete a course
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('dashboard')->with('success', 'Course deleted successfully!');
    }

    public function show(Course $course)
    {
        // Pastikan Course terambil berdasarkan slug
        return view('detail-courses', compact('course'));
    }

    // public function loadMore(Request $request)
    // {
    //     if ($request->ajax()) {
    //         // Ambil data kursus selanjutnya berdasarkan pagination
    //         $trendingCourses = Course::where('category_id', 'trending')->paginate(3, ['*'], 'page', $request->page);
            

    //         // Return view untuk kursus berikutnya
    //         return view('partials.course-card', compact('trendingCourses'))->render();
    //     }
    // }
    // app/Http/Controllers/CourseController.php
    // public function loadMore(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $trendingCourses = Course::where('category_id', 1)
    //             ->paginate(3, ['*'], 'page', $request->page);
                
    //         $isLoggedIn = Auth::check();
            
    //         if ($trendingCourses->count() > 0) {
    //             return view('partials.course-card', compact('trendingCourses', 'isLoggedIn'))->render();
    //         }
    //         return '';
    //     }
    // }
    // public function loadMore(Request $request)
    // {
    //     try {
    //         if ($request->ajax()) {
    //             $trendingCourses = Course::where('category_id', 1)
    //                 ->paginate(3, ['*'], 'page', $request->page);
                
    //             $isLoggedIn = Auth::check();
                
    //             // Debug: Log jumlah data yang diambil
    //             Log::info('Load More - Trending Courses count: ' . $trendingCourses->count());
                
    //             return view('partials.course-card', compact('trendingCourses', 'isLoggedIn'))->render();
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Error in loadMore: ' . $e->getMessage());
    //         return response()->json(['error' => 'No more courses available'], 404);
    //     }
    // }

    public function loadMore(Request $request)
{
    try {
        if ($request->ajax()) {
            $trendingCourses = Course::where('category_id', 1)
                ->paginate(3, ['*'], 'page', $request->page);
            
            $isLoggedIn = Auth::check();
            
            // Check if there are more pages
            $hasMorePages = $trendingCourses->hasMorePages();
            
            $view = view('partials.course-card', compact('trendingCourses', 'isLoggedIn'))->render();
            
            return response()->json([
                'html' => $view,
                'hasMorePages' => $hasMorePages
            ]);
        }
    } catch (\Exception $e) {
        Log::error('Error in loadMore: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}

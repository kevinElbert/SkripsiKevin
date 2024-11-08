<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CourseController extends Controller
{
    // Menampilkan halaman home dengan kursus
    public function showHome()
    {
        $trendingCourses = Course::where('category_id', 'trending')->paginate(3);
        $bestCoursesDeaf = Course::where('category_id', 'deaf')->paginate(3);
        $visitedCourses = Course::where('visited', true)->paginate(3);

        return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses'));
    }

    // Menampilkan form untuk membuat kursus baru
    public function create()
    {
        $categories = \App\Models\Category::all(); // Mengambil kategori
        return view('admin.create-course', compact('categories'));
    }

    // Menyimpan kursus baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'learning_points' => 'nullable|array',
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:20000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|integer',
            'is_published' => 'required|boolean',
        ]);

        $validatedData['admin_id'] = Auth::user()->id;
        $validatedData['category_id'] = $request->input('category');

        // Upload video dan image
        if ($request->hasFile('video')) {
            $validatedData['video'] = Cloudinary::uploadVideo($request->file('video')->getRealPath())->getSecurePath();
        }

        if ($request->hasFile('image')) {
            $validatedData['image'] = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        }

        // Simpan data ke database
        Course::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Course created successfully!');
    }
    // Menampilkan form edit kursus
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = \App\Models\Category::all(); // Mengambil kategori
        return view('admin.edit-course', compact('course', 'categories'));
    }

    // Mengupdate kursus
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'learning_points' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
            'category' => 'required|integer',
            'is_published' => 'required|boolean',
        ]);

        $validatedData['category_id'] = $request->input('category');

        // Upload video dan image jika ada
        if ($request->hasFile('image')) {
            $validatedData['image'] = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        }

        if ($request->hasFile('video')) {
            $validatedData['video'] = Cloudinary::uploadVideo($request->file('video')->getRealPath())->getSecurePath();
        }

        $course->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Course updated successfully!');
    }

    // Menghapus kursus
    public function destroy($id)
    {
        Course::findOrFail($id)->delete();
        return redirect()->route('dashboard')->with('success', 'Course deleted successfully!');
    }

    // Menampilkan detail kursus berdasarkan slug
    public function show($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        return view('courses.courses-detail', compact('course'));
    }
    public function loadMore(Request $request)
    {
        if ($request->ajax()) {
            // Ambil kategori dan halaman dari request
            $categoryId = $request->category_id;
            $courses = Course::where('category_id', $categoryId)->paginate(3, ['*'], 'page', $request->page);
    
            // Cek apakah pengguna sudah login
            $isLoggedIn = Auth::check();
    
            // Render view dengan mengirimkan $isLoggedIn
            $view = view('courses.courses-card', compact('courses', 'isLoggedIn'))->render();
    
            return response()->json([
                'html' => $view,
                'hasMorePages' => $courses->hasMorePages()
            ]);
        }
    }
    

    // Filter kursus berdasarkan pencarian dan kategori
    public function filterCourses(Request $request)
    {
        $query = Course::query();

        if ($request->has('search')) {
            $query->where('title', 'like', "%" . $request->input('search') . "%");
        }

        if ($request->has('filters') && !empty($request->filters)) {
            $query->whereIn('category', $request->filters);
        }

        $courses = $query->latest()->paginate(9);

        return response()->json(['courses' => $courses]);
    }

    public function info($slug)
    {
        // Ambil course berdasarkan slug
        $course = Course::where('slug', $slug)->with(['feedbacks.user'])->firstOrFail();

        // Kirim data course dan feedbacks ke view
        return view('courses.courses-information', compact('course'));
    }
}



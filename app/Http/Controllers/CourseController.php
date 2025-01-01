<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Thread;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Auth\Access\AuthorizesRequests;
use App\Models\Category;


class CourseController extends Controller
{
    public function showHome()
    {
        $trendingCourses = Course::where('category_id', 1)->paginate(3);
        $bestCoursesDeaf = Course::where('category_id', 2)->paginate(3);
        $visitedCourses = Course::where('category_id', 3)->paginate(3);

        return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.create-course', compact('categories'));
    }

    private function createForumThread($course)
    {
        // Membuat forum thread untuk course yang baru dibuat
        Thread::create([
            'course_id' => $course->id,
            'title' => 'Forum for ' . $course->title, // Judul forum sesuai dengan judul course
            'content' => 'This is the discussion forum for the course ' . $course->title, // Deskripsi forum bisa sesuai
            'user_id' => Auth::id(), // Admin yang membuat course, akan menjadi pembuat thread
        ]);
    }
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
            'sub_topics.*.title' => 'required|string|max:255',
            'sub_topics.*.description' => 'nullable|string',
            'sub_topics.*.video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000'
        ]);
        
        $validatedData['admin_id'] = Auth::user()->id;
        $validatedData['category_id'] = $request->input('category');
        
        if ($request->hasFile('video')) {
            $validatedData['video'] = Cloudinary::uploadVideo($request->file('video')->getRealPath())->getSecurePath();
        }
        
        if ($request->hasFile('image')) {
            $validatedData['image'] = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        }
        
        // Create the course
        $course = Course::create($validatedData);
        
        // Create a Forum thread automatically when course is created
        $this->createForumThread($course);
        
        // Create sub-topics
        if ($request->has('sub_topics')) {
            foreach ($request->sub_topics as $subTopicData) {
                $subTopicAttributes = [
                    'title' => $subTopicData['title'],
                    'description' => $subTopicData['description'],
                ];

                if (isset($subTopicData['video']) && $subTopicData['video'] instanceof \Illuminate\Http\UploadedFile) {
                    $subTopicAttributes['video'] = Cloudinary::uploadVideo($subTopicData['video']->getRealPath())->getSecurePath();
                }

                $course->subTopics()->create($subTopicAttributes);
            }
        }

        return redirect()->route('dashboard', $course->id)
                        ->with('success', 'Course and sub-topics created successfully!');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('admin.edit-course', compact('course', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:255',
            'learning_points' => 'nullable|array',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|integer',
            'is_published' => 'required|boolean',
            'sub_topics.*.title' => 'required|string|max:255',
            'sub_topics.*.description' => 'nullable|string',
            'sub_topics.*.video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000'
        ]);

        $validatedData['category_id'] = $request->input('category');

        if ($request->hasFile('image')) {
            $validatedData['image'] = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        }

        if ($request->hasFile('video')) {
            $validatedData['video'] = Cloudinary::uploadVideo($request->file('video')->getRealPath())->getSecurePath();
        }

        $course->update($validatedData);

        if ($request->has('sub_topics')) {
            foreach ($request->sub_topics as $index => $subTopicData) {
                if (isset($subTopicData['id'])) {
                    $subTopic = $course->subTopics()->find($subTopicData['id']);

                    $subTopicAttributes = [
                        'title' => $subTopicData['title'],
                        'description' => $subTopicData['description'],
                    ];

                    if (isset($subTopicData['video']) && $subTopicData['video'] instanceof \Illuminate\Http\UploadedFile) {
                        $subTopicAttributes['video'] = Cloudinary::uploadVideo($subTopicData['video']->getRealPath())->getSecurePath();
                    }

                    $subTopic->update($subTopicAttributes);
                } else {
                    $subTopicAttributes = [
                        'title' => $subTopicData['title'],
                        'description' => $subTopicData['description'],
                    ];

                    if (isset($subTopicData['video']) && $subTopicData['video'] instanceof \Illuminate\Http\UploadedFile) {
                        $subTopicAttributes['video'] = Cloudinary::uploadVideo($subTopicData['video']->getRealPath())->getSecurePath();
                    }

                    $course->subTopics()->create($subTopicAttributes);
                }
            }
        }

        return redirect()->route('dashboard')->with('success', 'Course and sub-topics updated successfully!');
    }

    public function destroy($id)
    {
        Course::findOrFail($id)->delete();
        return redirect()->route('dashboard')->with('success', 'Course deleted successfully!');
    }

    public function show($slug, Request $request)
    {
        $course = Course::where('slug', $slug)->with('subTopics')->firstOrFail();
        $subTopics = $course->subTopics;
    
        $currentSubTopic = $request->has('subTopic') ? $subTopics->where('id', $request->subTopic)->first() : $subTopics->first();
    
        $previousSubTopic = $subTopics->where('id', '<', $currentSubTopic->id)->last();
        $nextSubTopic = $subTopics->where('id', '>', $currentSubTopic->id)->first();
    
        return view('courses.courses-detail', compact('course', 'subTopics', 'currentSubTopic', 'previousSubTopic', 'nextSubTopic'));
    }

    public function loadMore(Request $request)
    {
        $categoryId = $request->input('category_id');
        $page = $request->input('page', 1);

        Log::info('LoadMore Request:', [
            'category_id' => $categoryId,
            'page' => $page
        ]);

        if (!$categoryId || !Category::where('id', $categoryId)->exists()) {
            Log::error("Invalid category_id received: {$categoryId}");
            return response()->json(['html' => '', 'hasMorePages' => false], 404);
        }

        $courses = Course::where('category_id', $categoryId)
            ->paginate(3, ['*'], 'page', $page);

        Log::info('Courses Query Result:', [
            'total_courses' => $courses->total(),
            'current_page' => $courses->currentPage(),
            'per_page' => $courses->perPage(),
            'has_more_pages' => $courses->hasMorePages()
        ]);

        if ($courses->isEmpty()) {
            Log::info("No courses found for category_id: {$categoryId}, page: {$page}");
            return response()->json(['html' => '', 'hasMorePages' => false]);
        }

        $isLoggedIn = Auth::check();
        $html = view('courses.courses-card', ['courses' => $courses, 'isLoggedIn' => $isLoggedIn])->render();

        return response()->json([
            'html' => $html,
            'hasMorePages' => $courses->hasMorePages(),
            'currentPage' => $courses->currentPage(),
            'total' => $courses->total()
        ]);
    }

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
        
        $course = Course::where('slug', $slug)->with(['feedbacks.user'])->firstOrFail();
        return view('courses.courses-information', compact('course'));
    }

    public function enroll($slug)
    {
        try {
            $course = Course::where('slug', $slug)->firstOrFail();
            $user = User::with('courses')->find(Auth::id());
            
            if ($user->courses->contains($course->id)) {
                return redirect()->back()
                    ->with('message', 'You have already enrolled in this course!');
            }
            
            $user->courses()->attach($course->id);
            
            return redirect()->route('courses.show', $course->slug)
                ->with('success', 'You have successfully enrolled in this course!');
                
        } catch (\Exception $e) {
            Log::error('Enrollment error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred during enrollment.');
        }
    }

    public function myLearning()
    {
        $user = User::with('courses')->find(Auth::id());
        $courses = $user->courses()->paginate(6);
        
        return view('courses.my-learning', compact('courses'));
    }

    // public function updateProgress(Request $request, $slug)
    // {
    //     $course = Course::where('slug', $slug)->firstOrFail();
    //     $user = Auth::user();
        
    //     // Menggunakan Query Builder untuk mengecek enrollment
    //     $enrollment = DB::table('user_courses')
    //         ->where('user_id', $user->id)
    //         ->where('course_id', $course->id)
    //         ->first();
        
    //     if (!$enrollment) {
    //         return redirect()->route('courses.show', $slug)
    //             ->with('error', 'You are not enrolled in this course.');
    //     }

    //     // Hitung progress baru
    //     $progressIncrease = $request->input('progress_increase', 10);
    //     $newProgress = min($enrollment->progress + $progressIncrease, 100);
        
    //     // Update menggunakan Query Builder
    //     DB::table('user_courses')
    //         ->where('user_id', $user->id)
    //         ->where('course_id', $course->id)
    //         ->update(['progress' => $newProgress]);

    //     return redirect()->route('courses.show', $slug)
    //         ->with('success', 'Progress updated successfully!');
    // }

    public function updateProgress(Request $request, $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $user = Auth::user();
        
        // Dapatkan data enrollment dari tabel pivot
        $enrollment = $user->courses()->where('course_id', $course->id)->first();
        
        if (!$enrollment) {
            return redirect()->route('courses.show', $slug)
                ->with('error', 'You are not enrolled in this course.');
        }

        // Ambil progress saat ini
        $currentProgress = $enrollment->pivot->progress ?? 0;
        
        // Hitung progress baru
        $progressIncrease = $request->input('progress_increase', 10);
        $newProgress = min($currentProgress + $progressIncrease, 100);
        
        // Update progress dengan syntax yang benar
        $user->courses()->syncWithoutDetaching([
            $course->id => ['progress' => $newProgress]
        ]);

        return redirect()->route('courses.show', $slug)
            ->with('success', 'Progress updated successfully!');
    }

    // public function completeSubTopic($courseSlug, $subTopicId)
    // {
    //     $course = Course::where('slug', $courseSlug)->firstOrFail();
    //     $user = Auth::user();
        
    //     // Cek enrollment dengan Query Builder
    //     $enrollment = DB::table('user_courses')
    //         ->where('user_id', $user->id)
    //         ->where('course_id', $course->id)
    //         ->first();
        
    //     if (!$enrollment) {
    //         return redirect()->route('courses.show', $courseSlug)
    //             ->with('error', 'You are not enrolled in this course.');
    //     }

    //     // Hitung progress
    //     $totalSubTopics = DB::table('sub_topics')
    //         ->where('course_id', $course->id)
    //         ->count();
        
    //     $progressPerSubTopic = 100 / max($totalSubTopics, 1);
    //     $newProgress = min($enrollment->progress + $progressPerSubTopic, 100);
        
    //     // Update progress
    //     DB::table('user_courses')
    //         ->where('user_id', $user->id)
    //         ->where('course_id', $course->id)
    //         ->update(['progress' => $newProgress]);

    //     return redirect()->route('courses.show', $courseSlug)
    //         ->with('success', 'Sub-topic completed! Progress updated.');
    // }

    public function completeSubTopic($courseSlug, $subTopicId)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $user = Auth::user();
        
        // Dapatkan data enrollment
        $enrollment = $user->courses()->where('course_id', $course->id)->first();
        
        if (!$enrollment) {
            return redirect()->route('courses.show', $courseSlug)
                ->with('error', 'You are not enrolled in this course.');
        }

        // Hitung progress per subtopic
        $totalSubTopics = $course->subTopics()->count();
        $progressPerSubTopic = 100 / max($totalSubTopics, 1); // Hindari pembagian dengan 0
        
        // Ambil progress saat ini
        $currentProgress = $enrollment->pivot->progress ?? 0;
        
        // Update progress
        $newProgress = min($currentProgress + $progressPerSubTopic, 100);
        
        // Update dengan syntax yang benar
        $user->courses()->syncWithoutDetaching([
            $course->id => ['progress' => $newProgress]
        ]);

        return redirect()->route('courses.show', $courseSlug)
            ->with('success', 'Sub-topic completed! Progress updated.');
    }
}

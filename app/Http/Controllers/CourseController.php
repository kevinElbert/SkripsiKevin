<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Thread;
use App\Models\SubTopic;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
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
            'sub_topics.*.video' => 'required|mimes:mp4,mov,ogg,qt|max:20000'
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
        Log::info($request->all());
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
            'sub_topics.*.id' => 'nullable|integer', // ID untuk sub-topik yang sudah ada
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

        // Sub-topik: update, tambah, atau hapus
        $existingSubTopicIds = $course->subTopics->pluck('id')->toArray(); // ID sub-topik yang sudah ada
        $incomingSubTopicIds = collect($request->sub_topics)->pluck('id')->filter()->toArray(); // ID sub-topik dari form

        // Hapus sub-topik yang tidak ada dalam request
        $subTopicsToDelete = array_diff($existingSubTopicIds, $incomingSubTopicIds);
        SubTopic::destroy($subTopicsToDelete);

        // Update atau tambahkan sub-topik
        foreach ($request->sub_topics as $subTopicData) {
            if (isset($subTopicData['id'])) {
                // Update sub-topik yang sudah ada
                $subTopic = $course->subTopics()->find($subTopicData['id']);
                $subTopicAttributes = [
                    'title' => $subTopicData['title'],
                    'description' => $subTopicData['description']
                ];

                if (isset($subTopicData['video']) && $subTopicData['video'] instanceof \Illuminate\Http\UploadedFile) {
                    $subTopicAttributes['video'] = Cloudinary::uploadVideo($subTopicData['video']->getRealPath())->getSecurePath();
                }

                $subTopic->update($subTopicAttributes);
            } else {
                // Tambah sub-topik baru
                $subTopicAttributes = [
                    'title' => $subTopicData['title'],
                    'description' => $subTopicData['description']
                ];

                if (isset($subTopicData['video']) && $subTopicData['video'] instanceof \Illuminate\Http\UploadedFile) {
                    $subTopicAttributes['video'] = Cloudinary::uploadVideo($subTopicData['video']->getRealPath())->getSecurePath();
                }

                $course->subTopics()->create($subTopicAttributes);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Course and sub-topics updated successfully!');
    }


    public function destroy($id)
    {
        $course = Course::findOrFail($id);
    
        // Hapus sub-topik terkait
        $course->subTopics()->each(function ($subTopic) {
            // Hapus video sub-topik dari Cloudinary
            if ($subTopic->video_url) {
                try {
                    Cloudinary::destroy($subTopic->video_url); // Sesuaikan jika ID Cloudinary berbeda
                } catch (\Exception $e) {
                    Log::error('Failed to delete sub-topic video: ' . $e->getMessage());
                }
            }
            $subTopic->delete();
        });
    
        // Hapus video dan gambar course dari Cloudinary
        if ($course->video) {
            try {
                Cloudinary::destroy($course->video);
            } catch (\Exception $e) {
                Log::error('Failed to delete course video: ' . $e->getMessage());
            }
        }
    
        if ($course->image) {
            try {
                Cloudinary::destroy($course->image);
            } catch (\Exception $e) {
                Log::error('Failed to delete course image: ' . $e->getMessage());
            }
        }
    
        // Hapus course dari database
        $course->delete();
    
        return redirect()->route('dashboard')->with('success', 'Course and related sub-topics deleted successfully!');
    }
    

    public function show($slug, Request $request)
    {
        $course = Course::where('slug', $slug)->with('subTopics')->firstOrFail();
        $subTopics = $course->subTopics;
    
        // Pilih sub-topik saat ini jika ada parameter 'subTopic', jika tidak ambil pertama
        $currentSubTopic = $request->has('subTopic') 
            ? $subTopics->where('id', $request->subTopic)->first() 
            : null;
    
        // Jika currentSubTopic tidak ditemukan, fallback ke course utama
        $currentSubTopic = $currentSubTopic ?? $course;
    
        // Cari sub-topik sebelumnya dan berikutnya
        $previousSubTopic = $subTopics->where('id', '<', optional($currentSubTopic)->id)->last();
        $nextSubTopic = $subTopics->where('id', '>', optional($currentSubTopic)->id)->first();
    
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

    public function updateProgress(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();
        
        // Dapatkan data enrollment dari tabel pivot
        $enrollment = $user->courses()->where('course_id', $course->id)->first();
        
        if (!$enrollment) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'You are not enrolled in this course.');
        }

        // Ambil progress saat ini
        $currentProgress = $enrollment->pivot->progress ?? 0;
        
        // Hitung progress baru
        $progressIncrease = $request->input('progress', 0);
        $newProgress = min($currentProgress + $progressIncrease, 100);

        Log::info('Updating progress:', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'current_progress' => $currentProgress,
            'progress_increase' => $progressIncrease,
            'new_progress' => $newProgress,
        ]);
        
        // Update progress dengan syntax yang benar
        $user->courses()->updateExistingPivot($course->id, ['progress' => $newProgress]);

        return redirect()->route('courses.show', $course->slug)
            ->with('success', 'Progress updated successfully!');
    }

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
    
        // Hitung total item (main course + sub topics + quiz)
        $totalItems = $course->subTopics()->count() + 2; // +2 untuk main course dan quiz
        $progressPerItem = 100 / $totalItems;
        
        // Ambil progress saat ini
        $currentProgress = $enrollment->pivot->progress ?? 0;
        
        // Update progress
        $newProgress = min($currentProgress + $progressPerItem, 100);
        
        // Update dengan syntax yang benar
        $user->courses()->updateExistingPivot($course->id, ['progress' => $newProgress]);
    
        return redirect()->route('courses.show', $courseSlug)
            ->with('success', 'Sub-topic completed! Progress updated.');
    }

    public function downloadVideo($courseId)
    {
        try {
            $course = Course::findOrFail($courseId);
            $user = Auth::user();

            // Check if user is enrolled
            if (!$user->courses->contains($course->id)) {
                return response()->json(['error' => 'You are not enrolled in this course.'], 403);
            }

            // Get video URL from Cloudinary
            $videoUrl = $course->video;
            if (!$videoUrl) {
                return response()->json(['error' => 'Video not found.'], 404);
            }

            // Get the video content from Cloudinary
            $videoContent = file_get_contents($videoUrl);
            if (!$videoContent) {
                return response()->json(['error' => 'Failed to fetch video content.'], 500);
            }

            // Return video as downloadable file
            return response($videoContent)
                ->header('Content-Type', 'video/mp4')
                ->header('Content-Disposition', 'attachment; filename="' . Str::slug($course->title) . '.mp4"')
                ->header('Content-Length', strlen($videoContent));

        } catch (\Exception $e) {
            Log::error('Error downloading video: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to download video: ' . $e->getMessage()], 500);
        }
    }

    public function getEnrolledCourses()
    {
        return auth()->user()->enrolledCourses()->select('id', 'title', 'slug')->get();
    }
}

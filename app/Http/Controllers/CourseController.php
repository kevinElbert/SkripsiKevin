<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CourseController extends Controller
{
    public function showHome()
    {
        $trendingCourses = Course::where('category_id', 'trending')->paginate(3);
        $bestCoursesDeaf = Course::where('category_id', 'deaf')->paginate(3);
        $visitedCourses = Course::where('visited', true)->paginate(3);

        return view('home', compact('trendingCourses', 'bestCoursesDeaf', 'visitedCourses'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.create-course', compact('categories'));
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
        
        $course = Course::create($validatedData);
    
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
        if ($request->ajax()) {
            $categoryId = $request->category_id;
            $courses = Course::where('category_id', $categoryId)->paginate(3, ['*'], 'page', $request->page);
            $isLoggedIn = Auth::check();
            $view = view('courses.courses-card', compact('courses', 'isLoggedIn'))->render();
    
            return response()->json([
                'html' => $view,
                'hasMorePages' => $courses->hasMorePages()
            ]);
        }
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SubTopic;
use Illuminate\Http\Request;

class AdminSubTopicController extends Controller
{
    public function index($courseId)
    {
        $course = Course::with('subTopics')->findOrFail($courseId);
        return view('admin.sub_topics.index', compact('course'));
    }

    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('admin.sub_topics.create', compact('course'));
    }

    public function store(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url'
        ]);

        SubTopic::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('admin.sub_topics.index', $courseId)
            ->with('success', 'Sub-Topic added successfully!');
    }

    public function edit($courseId, $subTopicId)
    {
        $course = Course::findOrFail($courseId);
        $subTopic = SubTopic::where('course_id', $courseId)->findOrFail($subTopicId);
        return view('admin.sub_topics.edit', compact('subTopic'));
    }

    public function update(Request $request, $courseId, $subTopicId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url'
        ]);

        $subTopic = SubTopic::where('course_id', $courseId)->findOrFail($subTopicId);
        $subTopic->update($request->all());

        return redirect()->route('admin.sub_topics.index', $courseId)
            ->with('success', 'Sub-Topic updated successfully!');
    }

    public function destroy($courseId, $subTopicId)
    {
        $subTopic = SubTopic::where('course_id', $courseId)->findOrFail($subTopicId);
        $subTopic->delete();

        return redirect()->route('admin.sub_topics.index', $courseId)
            ->with('success', 'Sub-Topic deleted successfully!');
    }
}


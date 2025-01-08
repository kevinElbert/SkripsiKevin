<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SubTopic;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;


class AdminSubTopicController extends Controller
{
    public function store(Request $request, $courseId)
    {
        dd($request->all());
        Log::info('Request data: ', $request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:20000'
        ]);

        $videoUrl = null;

        // Upload video ke Cloudinary jika ada
        if ($request->hasFile('video')) {
            try {
                $uploadedVideo = Cloudinary::uploadVideo($request->file('video')->getRealPath());
                $videoUrl = $uploadedVideo->getSecurePath();
                Log::info('Uploaded video URL: ' . $videoUrl);
            } catch (\Exception $e) {
                Log::error('Video upload failed: ' . $e->getMessage());
                return back()->with('error', 'Failed to upload video: ' . $e->getMessage());
            }
        }

        // Simpan sub-topic ke database
        $subTopic = SubTopic::create([
            'course_id' => $courseId,
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $videoUrl,
        ]);
        // SubTopic::create([
        //     'course_id' => $courseId,
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'video_url' => $videoUrl,
        // ]);
        Log::info('Sub-Topic created: ', $subTopic->toArray());

        return redirect()->route('admin.sub_topics.index', $courseId)
            ->with('success', 'Sub-Topic added successfully!');
    }

    public function update(Request $request, $courseId, $subTopicId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20000'
        ]);

        $subTopic = SubTopic::where('course_id', $courseId)->findOrFail($subTopicId);

        $videoUrl = $subTopic->video_url;

        // Upload video baru ke Cloudinary jika ada
        if ($request->hasFile('video')) {
            try {
                $uploadedVideo = Cloudinary::uploadVideo($request->file('video')->getRealPath());
                $videoUrl = $uploadedVideo->getSecurePath();
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to upload video: ' . $e->getMessage());
            }
        }

        // Update sub-topic
        $subTopic->update([
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $videoUrl,
        ]);

        return redirect()->route('admin.sub_topics.index', $courseId)
            ->with('success', 'Sub-Topic updated successfully!');
    }

    public function destroy($courseId, $subTopicId)
    {
        $subTopic = SubTopic::where('course_id', $courseId)->findOrFail($subTopicId);

        // Hapus video sub-topic dari Cloudinary
        if ($subTopic->video_url) {
            try {
                Cloudinary::destroy($subTopic->video_url); // Sesuaikan jika ID Cloudinary berbeda
            } catch (\Exception $e) {
                Log::error('Failed to delete sub-topic video: ' . $e->getMessage());
            }
        }

        // Hapus sub-topic dari database
        $subTopic->delete();

        return redirect()->back()->with('success', 'Sub-Topic deleted successfully!');
    }
}

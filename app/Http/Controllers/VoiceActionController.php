<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VoiceActionController extends Controller
{
    public function processCommand(Request $request)
    {
        $command = strtolower($request->input('command'));
        
        Log::info('Voice Command Received', ['command' => $command]);

        // Process commands untuk navigasi dan aksi
        $response = match (true) {
            str_contains($command, 'buka beranda') => [
                'action' => 'navigate',
                'url' => route('home'),
                'message' => 'Membuka halaman beranda'
            ],
            str_contains($command, 'buka my learning') => [
                'action' => 'navigate',
                'url' => route('courses.mylearning'),
                'message' => 'Membuka halaman My Learning'
            ],
            str_contains($command, 'buka kuis') => [
                'action' => 'navigate_quiz',
                'message' => 'Membuka halaman kuis'
            ],
            str_contains($command, 'buka forum') => [
                'action' => 'navigate',
                'url' => route('forum.index', ['course_id' => $this->getCurrentCourseId()]),
                'message' => 'Membuka forum diskusi'
            ],
            str_contains($command, 'baca teks') => [
                'action' => 'read_text',
                'message' => 'Membacakan teks di layar'
            ],
            str_contains($command, 'mode kontras') => [
                'action' => 'toggle_contrast',
                'message' => 'Mengubah mode kontras'
            ],
            str_contains($command, 'perbesar teks') => [
                'action' => 'increase_font',
                'message' => 'Memperbesar ukuran teks'
            ],
            str_contains($command, 'perkecil teks') => [
                'action' => 'decrease_font',
                'message' => 'Memperkecil ukuran teks'
            ],
            default => [
                'action' => 'unknown',
                'message' => 'Perintah tidak dikenali'
            ]
        };

        Log::info('Voice Command Processed', ['response' => $response]);

        return response()->json($response);
    }

    public function searchCourse(Request $request)
    {
        $query = $request->get('q');
        $course = Course::where('title', 'LIKE', "%{$query}%")->first();
        
        if ($course) {
            return response()->json([
                'found' => true,
                'url' => route('courses.show', $course->slug)
            ]);
        }
        
        return response()->json([
            'found' => false,
            'message' => 'Kursus tidak ditemukan'
        ]);
    }

    private function getCurrentCourseId()
    {
        return request()->route('course_id');
    }
}
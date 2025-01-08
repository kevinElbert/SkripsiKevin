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
        Log::info('Voice Command Received:', ['command' => $command]);
        // Process commands untuk navigasi dan aksi
        $response = match(true) {
            // Navigasi Utama
            str_contains($command, 'buka beranda') || str_contains($command, 'ke beranda') => [
                
                'action' => 'navigate',
                'url' => route('home'),
                'message' => 'Membuka halaman beranda'
            ],
            str_contains($command, 'buka my learning') || str_contains($command, 'ke my learning') => [
                'action' => 'navigate',
                'url' => route('courses.mylearning'),
                'message' => 'Membuka halaman my learning'
            ],
            // Quiz
            str_contains($command, 'buka kuis') || str_contains($command, 'lihat kuis') => [
                'action' => 'navigate_quiz',
                'message' => 'Mencari kuis yang tersedia'
            ],
            // Forum
            str_contains($command, 'buka forum') || str_contains($command, 'lihat forum') => [
                'action' => 'navigate_forum',
                'message' => 'Membuka forum diskusi'
            ],
            // Profil dan Pengaturan
            str_contains($command, 'buka profil') || str_contains($command, 'ke profil') => [
                'action' => 'navigate',
                'url' => route('profile.edit'),
                'message' => 'Membuka halaman profil'
            ],
            // Kursus Spesifik
            str_contains($command, 'buka kursus') => [
                'action' => 'search_course',
                'query' => trim(str_replace('buka kursus', '', $command)),
                'message' => 'Mencari kursus yang diminta'
            ],
            str_contains($command, 'cari kursus') => [
                'action' => 'search_course',
                'query' => trim(str_replace('cari kursus', '', $command)),
                'message' => 'Mencari kursus yang diminta'
            ],
            // Fitur Aksesibilitas
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
            // Text to Speech untuk konten
            str_contains($command, 'baca teks') || str_contains($command, 'bacakan') => [
                'action' => 'read_text',
                'message' => 'Membacakan teks di layar'
            ],
            default => [
                'action' => 'unknown',
                'message' => 'Maaf, perintah tidak dikenali'
            ]
        };

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
}
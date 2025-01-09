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
        try {
            $command = strtolower($request->input('command'));
            Log::info('Voice Command Received', ['command' => $command]);

            // Tambahkan log untuk memeriksa request yang masuk
            Log::info('Full Request:', $request->all());

            // Ambil course_id dari context
            $courseId = $this->getCurrentCourseId($request);
            Log::info('Extracted Course ID:', ['course_id' => $courseId]);

            // Proses perintah voice
            $response = match (true) {
                str_contains($command, 'buka forum') => [
                    'action' => 'navigate',
                    'url' => $courseId ? route('forum.index', ['course_id' => $courseId]) : null,
                    'message' => $courseId ? 'Membuka forum diskusi' : 'ID course tidak ditemukan untuk forum'
                ],
                str_contains($command, 'buka kuis') => [
                    'action' => 'navigate',
                    'url' => $courseId ? route('user.quiz.show', ['courseId' => $courseId]) : null,
                    'message' => $courseId ? 'Membuka halaman kuis' : 'ID kursus tidak ditemukan untuk kuis'
                ],
                str_contains($command, 'buka my learning') => [
                    'action' => 'navigate',
                    'url' => route('courses.mylearning'),
                    'message' => 'Membuka halaman My Learning'
                ],
                str_contains($command, 'buka beranda') => [
                    'action' => 'navigate',
                    'url' => route('home'),
                    'message' => 'Membuka halaman beranda'
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
                str_contains($command, 'baca teks') => [
                    'action' => 'read_text',
                    'message' => 'Membacakan teks di layar'
                ],
                default => [
                    'action' => 'unknown',
                    'message' => 'Perintah tidak dikenali'
                ]
            };

            Log::info('Voice Command Processed', ['response' => $response]);
            
            if (($response['action'] === 'navigate' && !$response['url']) || 
                $response['action'] === 'error') {
                return response()->json([
                    'action' => 'error',
                    'message' => 'ID kursus tidak ditemukan. Pastikan Anda berada di halaman kursus.'
                ]);
            }

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error processing voice command', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'action' => 'error',
                'message' => 'Terjadi kesalahan saat memproses perintah'
            ], 500);
        }
    }

    public function searchCourse(Request $request)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error searching course', [
                'query' => $query ?? null,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'found' => false,
                'message' => 'Terjadi kesalahan saat mencari kursus'
            ], 500);
        }
    }

    private function getCurrentCourseId(Request $request)
    {
        // 1. Coba ambil dari request langsung
        $courseId = $request->input('course_id');
        if ($courseId) {
            Log::info('Course ID found in request', ['course_id' => $courseId]);
            return $courseId;
        }

        // 2. Coba ambil dari route parameter
        $courseId = $request->route('course_id');
        if ($courseId) {
            Log::info('Course ID found in route', ['course_id' => $courseId]);
            return $courseId;
        }

        // 3. Coba ambil dari previous URL jika ada
        if ($request->headers->has('referer')) {
            $referer = $request->headers->get('referer');
            if (preg_match('/courses\/(\d+)/', $referer, $matches)) {
                $courseId = $matches[1];
                Log::info('Course ID found in referer', ['course_id' => $courseId]);
                return $courseId;
            }
        }

        // 4. Coba ambil dari session
        if (session()->has('current_course_id')) {
            $courseId = session('current_course_id');
            Log::info('Course ID found in session', ['course_id' => $courseId]);
            return $courseId;
        }

        Log::warning('No course ID found in any location');
        return null;
    }
}
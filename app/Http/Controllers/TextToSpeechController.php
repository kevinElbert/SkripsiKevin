<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\VoiceRSS;
use Illuminate\Support\Facades\Log;

class TextToSpeechController extends Controller
{
    public function generateSpeech(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'lang' => 'required|string',
        ]);

        $tts = new VoiceRSS();
        $voice = $tts->speech([
            'key' => env('VOICE_RSS_API_KEY'),
            'hl' => $request->lang,
            'src' => $request->text,
            'r' => '0',
            'c' => 'mp3',
            'f' => '44khz_16bit_stereo',
            'ssml' => 'false',
            'b64' => 'false',
        ]);

        if (isset($voice['error'])) {
            return response()->json(['error' => $voice['error']], 500);
        }

        // Simpan audio ke storage
        $audioPath = 'speeches/' . uniqid() . '.mp3';
        file_put_contents(storage_path('app/public/' . $audioPath), $voice);

        try {
            file_put_contents(storage_path('app/public/' . $audioPath), $voice['response']);
        } catch (\Exception $e) {
            Log::error('Error saving TTS audio: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save audio'], 500);
        }        

        return response()->json([
            'message' => 'TTS generated successfully!',
            'audio_url' => asset('storage/' . $audioPath),
        ]);
    }
}


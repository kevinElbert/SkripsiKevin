@extends('main')

@section('title', 'Text to Speech')

@section('content')
<div class="container mx-auto my-8">
    <h2 class="text-2xl font-bold">Text-to-Speech Converter</h2>
    <form id="ttsForm" action="{{ route('tts.generate') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="text">Enter Text:</label>
            <textarea name="text" id="text" class="w-full p-2 border rounded" required></textarea>
        </div>
        <div class="mb-4">
            <label for="lang">Language:</label>
            <select name="lang" id="lang" class="w-full p-2 border rounded" required>
                <option value="en-us">English (US)</option>
                <option value="id-id">Indonesian</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Generate Speech</button>
    </form>
    <div id="audioContainer" class="mt-4 hidden">
        <h3 class="text-xl">Generated Speech:</h3>
        <audio controls id="audioPlayer"></audio>
    </div>
</div>

<script>
    const form = document.getElementById('ttsForm');
    const audioContainer = document.getElementById('audioContainer');
    const audioPlayer = document.getElementById('audioPlayer');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);

        const response = await fetch('{{ route('tts.generate') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        });

        const result = await response.json();
        if (response.ok) {
            audioContainer.classList.remove('hidden');
            audioPlayer.src = result.audio_url;
        } else {
            alert(result.message || 'Error generating speech!');
        }
    });
</script>
@endsection

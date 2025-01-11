@extends('main')

@section('title', 'Edit Quiz')

@section('content')
<div class="container mx-auto my-8 px-4">
    <h2 class="text-2xl font-bold mb-6">Edit Quiz</h2>

    <form action="{{ route('quizzes.update', $quiz->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Input untuk Judul Quiz -->
        <div class="mb-4">
            <label for="title" class="block font-bold mb-2">Quiz Title</label>
            <input type="text" id="title" name="title" value="{{ $quiz->title }}" 
                   class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>

        <!-- Pengaturan Quiz -->
        <div class="mb-4">
            <label class="block font-bold">Passing Score (%)</label>
            <input type="number" name="passing_score" value="{{ $quiz->passing_score }}" 
                   min="0" max="100" class="w-full border-gray-300 rounded-md shadow-sm" required>
            
            <label class="block font-bold mt-2">Time Limit (minutes)</label>
            <input type="number" name="time_limit" value="{{ $quiz->time_limit }}" 
                   min="0" class="w-full border-gray-300 rounded-md shadow-sm">
            
            <label class="block font-bold mt-2">Attempts Allowed</label>  
            <input type="number" name="attempts_allowed" value="{{ $quiz->attempts_allowed }}" 
                   min="0" class="w-full border-gray-300 rounded-md shadow-sm">

            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_published" value="1" 
                           {{ $quiz->is_published ? 'checked' : '' }} class="rounded border-gray-300">
                    <span class="ml-2">Published</span>
                </label>
            </div>
        </div>

        <!-- Media Upload -->
        <div class="mb-4">
            <label class="block font-bold">Media (Optional)</label>
            @if($quiz->media)
                <div class="mb-2">
                    <p>Current Media:</p>
                    @foreach($quiz->media as $media)
                        <div class="flex items-center gap-2">
                            <span>{{ basename($media) }}</span>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remove_media[]" value="{{ $media }}">
                                <span class="ml-2">Remove</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif
            <input type="file" name="media[]" multiple class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Bagian untuk Soal dan Pilihan Ganda -->
        <div id="questions-container">
            <h3 class="font-bold mb-2">Questions</h3>
            @foreach($quiz->questions as $index => $question)
                <div class="question mb-4 border p-4 rounded-md shadow-md">
                    <label class="block font-bold">Question</label>
                    <input type="text" name="questions[{{ $index }}][question]" 
                           value="{{ $question['question'] }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm" required>

                    <label class="block font-bold mt-2">Options</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($question['options'] as $optionIndex => $option)
                            <input type="text" name="questions[{{ $index }}][options][{{ $optionIndex }}]" 
                                   value="{{ $option }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm" required>
                        @endforeach
                    </div>

                    <label class="block font-bold mt-2">Correct Answer</label>
                    <input type="text" name="questions[{{ $index }}][correct_answer]" 
                           value="{{ $question['correct_answer'] }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
            @endforeach
        </div>

        <div class="flex gap-4">
            <button type="button" id="add-question" class="bg-green-500 text-white px-4 py-2 rounded-md">
                Add Another Question
            </button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                Save Changes
            </button>
        </div>
    </form>
</div>

<script>
    // Script untuk menambah pertanyaan (sama seperti create.blade.php)
    document.getElementById('add-question').addEventListener('click', function () {
        // ... (script yang sama seperti di create.blade.php)
    });
</script>
@endsection
@extends('main')

@section('title', 'Edit Quiz')

@section('content')
<form action="{{ route('quizzes.update', $quiz->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Input untuk Judul Quiz -->
    <div class="mb-4">
        <label for="title" class="block font-bold mb-2">Quiz Title</label>
        <input type="text" id="title" name="title" value="{{ $quiz->title }}" 
               class="w-full border-gray-300 rounded-md shadow-sm" required>
    </div>

    <!-- Bagian untuk Soal dan Pilihan Ganda -->
    <div id="questions-container">
        <h3 class="font-bold mb-2">Questions</h3>
        @foreach($quiz->questions as $index => $question)
            <div class="question mb-4 border p-4 rounded-md shadow-md">
                <label for="questions[{{ $index }}][question]" class="block font-bold mb-1">Question</label>
                <input type="text" name="questions[{{ $index }}][question]" 
                       value="{{ $question['question'] }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm" required>

                <label for="questions[{{ $index }}][options][]" class="block font-bold mt-2">Options</label>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($question['options'] as $optionIndex => $option)
                        <input type="text" name="questions[{{ $index }}][options][{{ $optionIndex }}]" 
                               value="{{ $option }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                    @endforeach
                </div>

                <label for="questions[{{ $index }}][correct_answer]" class="block font-bold mt-2">Correct Answer</label>
                <input type="text" name="questions[{{ $index }}][correct_answer]]" 
                       value="{{ $question['correct_answer'] }}" 
                       class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
        @endforeach
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Save Changes</button>
</form>
@endsection

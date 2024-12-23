@extends('main')

@section('title', 'Create Quiz')

@section('content')
<main class="container mx-auto my-8 px-4">
    <h2 class="text-2xl font-bold mb-6">Create Quiz for "{{ $courseTitle }}"</h2>

    <form action="{{ route('quizzes.store') }}" method="POST" class="space-y-6">
        @csrf
        <!-- Hidden Input untuk Course ID -->
        <input type="hidden" name="course_id" value="{{ $courseId }}">
        <input type="hidden" name="title" value="{{ $courseTitle }}">

        <!-- Container untuk Pertanyaan -->
        <div id="questions-container" class="space-y-4">
            <h3 class="font-bold mb-2">Questions</h3>
            <div class="question border rounded-md p-4 shadow-sm space-y-2">
                <label class="block font-bold">Question</label>
                <input type="text" name="questions[0][question]" class="w-full border-gray-300 rounded-md shadow-sm" required>

                <label class="block font-bold mt-2">Options</label>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="questions[0][options][]" placeholder="Option A" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    <input type="text" name="questions[0][options][]" placeholder="Option B" class="w-full border-gray-300 rounded-md shadow-sm" required>
                    <input type="text" name="questions[0][options][]" placeholder="Option C" class="w-full border-gray-300 rounded-md shadow-sm">
                    <input type="text" name="questions[0][options][]" placeholder="Option D" class="w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <label class="block font-bold mt-2">Correct Answer</label>
                <input type="text" name="questions[0][correct_answer]" placeholder="Enter correct option (A/B/C/D)" class="w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
        </div>

        <button type="button" id="add-question" class="bg-green-500 text-white px-4 py-2 rounded-md">Add Another Question</button>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Save Quiz</button>
    </form>
</main>

<script>
    document.getElementById('add-question').addEventListener('click', function () {
    const container = document.getElementById('questions-container');
    const questionCount = container.querySelectorAll('.question').length;

    const questionHTML = `
        <div class="question border rounded-md p-4 shadow-sm space-y-2">
            <label class="block font-bold">Question</label>
            <input type="text" name="questions[${questionCount}][question]" class="w-full border-gray-300 rounded-md shadow-sm" required>

            <label class="block font-bold mt-2">Options</label>
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="questions[${questionCount}][options][]" placeholder="Option A" class="w-full border-gray-300 rounded-md shadow-sm" required>
                <input type="text" name="questions[${questionCount}][options][]" placeholder="Option B" class="w-full border-gray-300 rounded-md shadow-sm" required>
                <input type="text" name="questions[${questionCount}][options][]" placeholder="Option C" class="w-full border-gray-300 rounded-md shadow-sm">
                <input type="text" name="questions[${questionCount}][options][]" placeholder="Option D" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <label class="block font-bold mt-2">Correct Answer</label>
            <input type="text" name="questions[${questionCount}][correct_answer]" placeholder="Enter correct option (A/B/C/D)" class="w-full border-gray-300 rounded-md shadow-sm" required>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', questionHTML);
});
</script>
@endsection

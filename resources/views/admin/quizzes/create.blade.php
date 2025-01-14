@extends('main')

@section('title', 'Create Quiz')

@section('content')
<main class="container mx-auto my-8 px-4">
    <h2 class="text-2xl font-bold mb-6">Create Quiz for "{{ $courseTitle }}"</h2>

    <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <!-- Hidden Input untuk Course ID -->
        <input type="hidden" name="course_id" value="{{ $courseId }}">
        <input type="hidden" name="title" value="{{ $courseTitle }}">

        <!-- Pengaturan Quiz -->
        <div class="mb-4">
            <label class="block font-bold">Passing Score (%)</label>
            <input type="number" name="passing_score" min="0" max="100" class="w-full border-gray-300 rounded-md shadow-sm" required>
            
            <label class="block font-bold mt-2">Time Limit (minutes)</label>
            <input type="number" name="time_limit" min="0" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('time_limit', $quiz->time_limit) }}">
            
            <label class="block font-bold mt-2">Attempts Allowed (0 for unlimited)</label>
            <input type="number" name="attempts_allowed" min="0" class="w-full border-gray-300 rounded-md shadow-sm" value="{{ old('attempts_allowed', $quiz->attempts_allowed) }}">
            
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300">
                    <span class="ml-2">Publish Quiz</span>
                </label>
            </div>
        </div>

        <!-- Media Upload (Optional) -->
        <div class="mb-4">
            <label class="block font-bold">Media (Optional)</label>
            <input type="file" name="media[]" multiple class="w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <!-- Container untuk Pertanyaan -->
        <div id="questions-container" class="space-y-4">
            <h3 class="font-bold mb-2">Questions</h3>
            <div class="question border rounded-md p-4 shadow-sm space-y-2">
                <div class="flex justify-between items-center mb-2">
                    <label class="block font-bold">Question</label>
                    <button type="button" class="delete-question text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i> Delete Question
                    </button>
                </div>
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
    document.getElementById('add-question').addEventListener('click', function() {
        const container = document.getElementById('questions-container');
        const questionCount = container.querySelectorAll('.question').length;

        const questionHTML = `
            <div class="question border rounded-md p-4 shadow-sm space-y-2">
                <div class="flex justify-between items-center mb-2">
                    <label class="block font-bold">Question</label>
                    <button type="button" class="delete-question text-red-500 hover:text-red-700">
                        <i class="fas fa-trash"></i> Delete Question
                    </button>
                </div>
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
        attachDeleteHandlers();
    });

    // Fungsi untuk menambahkan event listener ke tombol delete
    function attachDeleteHandlers() {
        document.querySelectorAll('.delete-question').forEach(button => {
            button.addEventListener('click', function() {
                const questionDiv = this.closest('.question');
                const container = document.getElementById('questions-container');
                
                // Hanya hapus jika ada lebih dari 1 pertanyaan
                if (container.querySelectorAll('.question').length > 1) {
                    questionDiv.remove();
                    reorderQuestions();
                } else {
                    alert('You must have at least one question!');
                }
            });
        });
    }

    // Fungsi untuk mengurutkan ulang indeks pertanyaan setelah penghapusan
    function reorderQuestions() {
        const questions = document.querySelectorAll('.question');
        questions.forEach((question, index) => {
            const inputs = question.querySelectorAll('input[name*="questions"]');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                input.setAttribute('name', name.replace(/questions\[\d+\]/, `questions[${index}]`));
            });
        });
    }

    // Attach handlers saat halaman dimuat
    attachDeleteHandlers();
</script>
@endsection
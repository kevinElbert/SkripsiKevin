@extends('main')

@section('title', 'Taking Quiz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ $quiz->title }}</h1>
        @if($quiz->time_limit)
        <div class="text-xl font-mono" id="timer">
            <span id="minutes">{{ $quiz->time_limit }}</span>:
            <span id="seconds">00</span>
        </div>
        @endif
    </div>

    <form id="quizForm" action="{{ route('user.quiz.submit', $quiz->id) }}" method="POST" 
          class="bg-white rounded-lg shadow-md p-6">
        @csrf
        
        @foreach($quiz->questions as $index => $question)
        <div class="mb-8 question-container">
            <div class="flex items-start">
                <span class="bg-blue-100 text-blue-800 font-semibold px-3 py-1 rounded-full mr-3">
                    {{ $index + 1 }}
                </span>
                <div class="flex-1">
                    <p class="text-lg font-medium mb-4">{{ $question['question'] }}</p>
                    <div class="space-y-3">
                        @foreach($question['options'] as $optionIndex => $option)
                        <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="radio" 
                                   name="answers[{{ $index }}]" 
                                   value="{{ $option }}"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500" 
                                   required>
                            <span class="ml-3">{{ $option }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="mt-6 flex justify-between items-center">
            <span class="text-sm text-gray-600">
                * Answer all questions before submitting
            </span>
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                Submit Quiz
            </button>
        </div>
    </form>
</div>

@if($quiz->time_limit)
<script>
    // Timer functionality
    let timeLeft = {{ $quiz->time_limit * 60 }};
    const timerDisplay = setInterval(() => {
        timeLeft--;
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
        document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        
        if (timeLeft <= 0) {
            clearInterval(timerDisplay);
            document.getElementById('quizForm').submit();
        }
    }, 1000);
</script>
@endif
@endsection
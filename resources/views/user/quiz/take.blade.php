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

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg text-center">
                <p class="text-gray-600 text-sm">Time Limit</p>
                <p class="text-xl font-medium">{{ $quiz->time_limit ?? 'No limit' }} minutes</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg text-center">
                <p class="text-gray-600 text-sm">Attempts</p>
                <p class="text-xl font-medium">{{ $attemptCount }}/{{ $quiz->attempts_allowed }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg text-center">
                <p class="text-gray-600 text-sm">Highest Score</p>
                <p class="text-xl font-medium">{{ $highestScore }}%</p>
            </div>
        </div>

        <form id="quizForm" action="{{ route('user.quiz.submit', ['courseId' => $quiz->course_id]) }}" method="POST">
            @csrf
            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
            
            @foreach($quiz->questions as $index => $question)
                <div class="mb-8 question-container">
                    <div class="flex items-start">
                        <span class="bg-blue-100 text-blue-800 font-semibold px-3 py-1 rounded-full mr-3">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1">
                            <p class="text-lg font-medium mb-4">{{ $question['question'] }}</p>
                            
                            @if(isset($question['media']))
                                <div class="mb-4">
                                    <img src="{{ $question['media'] }}" alt="Question media" class="max-w-full h-auto rounded-lg">
                                </div>
                            @endif
                            
                            <div class="space-y-3">
                                @foreach($question['options'] as $option)
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
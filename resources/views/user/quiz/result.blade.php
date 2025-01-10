@extends('main')

@section('title', 'Quiz Result')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <p class="font-bold">{{ session('success') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Quiz Result Header -->
        <div class="bg-blue-50 p-6 border-b border-blue-100">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Quiz Results</h1>
            <p class="text-gray-600">{{ $quizResults->first()->quiz->title ?? 'Quiz Results' }}</p>
        </div>

        <!-- Result Summary -->
        <div class="p-6">
            @forelse($quizResults as $result)
            <div class="mb-8 last:mb-0">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-gray-600 text-sm mb-1">Your Score</p>
                        <p class="text-3xl font-bold {{ $result->getPercentageScore() >= $result->quiz->passing_score ? 'text-green-600' : 'text-red-600' }}">
                            {{ $result->score }}/{{ $result->total_questions }}
                        </p>
                        <p class="text-gray-500 text-sm">({{ number_format($result->getPercentageScore(), 1) }}%)</p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-gray-600 text-sm mb-1">Passing Score</p>
                        <p class="text-3xl font-bold text-gray-700">
                            {{ $result->quiz->passing_score }}%
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-gray-600 text-sm mb-1">Status</p>
                        @if($result->hasPassed())
                            <p class="text-2xl font-bold text-green-600">PASSED</p>
                        @else
                            <p class="text-2xl font-bold text-red-600">NOT PASSED</p>
                        @endif
                    </div>
                </div>

                <!-- Attempt Info -->
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Attempt Date</p>
                            <p class="font-medium">{{ $result->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Time Taken</p>
                            <p class="font-medium">{{ $result->created_at->diffForHumans($result->created_at->addMinutes($result->quiz->time_limit ?? 0), true) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-4">
                    @if(!$result->hasPassed() && $result->quiz->canUserTakeQuiz(auth()->id()))
                        <a href="{{ route('user.quiz.show', ['courseId' => $courseId]) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                            Try Again
                        </a>
                    @endif

                    <a href="{{ route('courses.show', ['slug' => $result->quiz->course->slug]) }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                        Back to Course
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <p class="text-gray-500">No quiz results available.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
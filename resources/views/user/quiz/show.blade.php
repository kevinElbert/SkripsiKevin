@extends('main')

@section('title', 'Take Quiz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $course->title }} - Quizzes</h1>

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        @forelse($quizzes as $quizData)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">{{ $quizData['quiz']->title }}</h2>
                    <span class="text-sm text-gray-500">
                        Attempts: {{ $quizData['attempts'] }}/{{ $quizData['quiz']->attempts_allowed }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600 text-sm">Time Limit</p>
                        <p class="text-lg font-medium">{{ $quizData['quiz']->time_limit ?? 'No limit' }} minutes</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-600 text-sm">Passing Score</p>
                        <p class="text-lg font-medium">{{ $quizData['quiz']->passing_score }}%</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <p class="text-gray-600 text-sm">Highest Score</p>
                        <p class="text-lg font-medium">{{ $quizData['highest_score'] }}%</p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        @if($quizData['has_passed'])
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                Passed
                            </span>
                        @endif
                    </div>
                    
                    @if($quizData['can_take'])
                        <a href="{{ route('user.quiz.take', $quizData['quiz']->id) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                            Start Quiz
                        </a>
                    @else
                        <span class="text-gray-500">Maximum attempts reached</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-gray-50 rounded-lg p-6 text-center">
                <p class="text-gray-600">No quizzes available for this course.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
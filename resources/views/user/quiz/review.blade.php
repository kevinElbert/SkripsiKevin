@extends('main')

@section('title', 'Quiz Review')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">{{ $quiz->title }} - Review</h1>
            <p class="text-gray-600">Your Score: {{ $result->score }}/{{ $result->total_questions }} ({{ number_format($result->percentage_score, 1) }}%)</p>
        </div>

        <div class="space-y-8">
            @foreach($quiz->questions as $index => $question)
                <div class="border rounded-lg p-6 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                    <div class="flex items-start">
                        <span class="bg-blue-100 text-blue-800 font-semibold px-3 py-1 rounded-full mr-3">
                            {{ $index + 1 }}
                        </span>
                        <div class="flex-1">
                            <p class="text-lg font-medium mb-4">{{ $question['question'] }}</p>
                            
                            <div class="space-y-3">
                                @foreach($question['options'] as $optionIndex => $option)
                                    <div class="p-3 border rounded-lg {{ chr(65 + $optionIndex) === $question['correct_answer'] ? 'bg-green-100 border-green-300' : '' }}">
                                        <div class="flex items-center justify-between">
                                            <span class="flex items-center">
                                                <span class="font-medium mr-2">{{ chr(65 + $optionIndex) }}.</span>
                                                {{ $option }}
                                            </span>
                                            @if(chr(65 + $optionIndex) === $question['correct_answer'])
                                                <span class="text-green-600 font-medium">✓ Correct Answer</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('courses.show', $quiz->course->slug) }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                Back to Course
            </a>
        </div>
    </div>
</div>
@endsection
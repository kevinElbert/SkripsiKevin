@extends('main')

@section('title', 'Quiz Details')

@section('content')
<div class="container mx-auto my-8 px-4">
    <h1 class="text-2xl font-bold mb-4">Quiz Details</h1>
    <div class="border p-4 rounded-md shadow-md">
        <h2 class="font-bold">Title: {{ $quiz->title }}</h2>
        <p class="mt-2">Course: {{ $quiz->course->title }}</p>
        <h3 class="font-bold mt-4">Questions:</h3>
        <ol class="list-decimal pl-6">
            @foreach($quiz->questions as $index => $question)
                <li class="mt-2">
                    <p class="font-bold">{{ $index + 1 }}. {{ $question['question'] }}</p>
                    <ul class="list-disc pl-6">
                        @foreach($question['options'] as $option)
                            <li>{{ $option }}</li>
                        @endforeach
                    </ul>
                    <p class="font-bold mt-2">Correct Answer: {{ $question['correct_answer'] }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</div>
@endsection

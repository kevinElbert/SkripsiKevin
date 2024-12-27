@extends('main')

@section('title', 'Quiz Results')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Your Quiz Results</h1>
    @foreach ($quizResults as $result)
        <div class="border p-4 mb-4 rounded shadow">
            <h2 class="font-bold text-xl">{{ $result->quiz->title }}</h2>
            <p>Score: {{ $result->score }} / {{ $result->total_questions }}</p>
        </div>
    @endforeach
    {{-- <a href="{{ route('courses.show', $courseId) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Back to Course</a> --}}
    <a href="{{ route('courses.show', ['slug' => $quizResults->first()->quiz->course->slug]) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Back to Course</a>
</div>
@endsection

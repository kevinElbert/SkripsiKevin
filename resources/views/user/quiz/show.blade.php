@extends('main')

@section('title', 'Quiz for ' . $course->title)

@section('content')
<div class="container" data-course-id="{{ $course->id }}">
    <h1 class="text-2xl font-bold mb-4">Quizzes for {{ $course->title }}</h1>

    @foreach ($quizzes as $quiz)
        <div class="border p-4 mb-4 rounded shadow">
            <h2 class="font-bold text-xl">{{ $quiz->title }}</h2>
            <form action="{{ route('user.quiz.submit', $course->id) }}" method="POST">
                @csrf
                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                @foreach ($quiz->questions as $index => $question)
                    <div class="mb-4">
                        <p class="font-bold">{{ $index + 1 }}. {{ $question['question'] }}</p>
                        @foreach ($question['options'] as $option)
                            <label>
                                <input type="radio" name="answers[{{ $index }}]" value="{{ $option }}" required>
                                {{ $option }}
                            </label><br>
                        @endforeach
                    </div>
                @endforeach
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit Quiz</button>
            </form>
        </div>
    @endforeach
</div>
@endsection

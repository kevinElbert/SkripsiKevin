{{-- @extends('main')

@section('title', $course->title)

@section('content')
<div class="container mx-auto my-8 px-4">
    <!-- Course Information Section -->
    <section class="bg-white p-6 rounded shadow">
        <h1 class="text-3xl font-bold">{{ $course->title }}</h1>
        
        <!-- Short Description Section -->
        <p class="text-gray-700 my-4">{{ $course->short_description }}</p>
        
        @if($course->image)
            <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded my-4">
        @endif
        
        <!-- What You Will Learn Section -->
        <h2 class="text-2xl font-semibold mt-8">What you will learn?</h2>
        <ul class="list-disc pl-6">
            @foreach($course->learning_points as $point)
                <li>{{ $point }}</li>
            @endforeach
        </ul>

        <!-- Full Description Section (Optional) -->
        <h2 class="text-2xl font-semibold mt-8">Full Description</h2>
        <p class="text-gray-700">{{ $course->description }}</p>
    </section>

    <!-- Feedback Section -->
    <section class="bg-white p-6 rounded shadow mt-8">
        <h2 class="text-2xl font-semibold">What they say?</h2>
        
        @if($course->feedbacks->isEmpty())
            <p class="text-gray-600">No feedback available for this course.</p>
        @else
            @foreach($course->feedbacks as $feedback)
                <div class="border-b border-gray-200 py-4">
                    <p class="font-semibold">{{ $feedback->user->name ?? $feedback->user_name }}</p>
                    <p class="text-gray-700">{{ $feedback->comment }}</p>
                    <p class="text-yellow-500">Rating: {{ $feedback->rating }} / 5</p>
                </div>
            @endforeach
        @endif
    </section>
</div>
@endsection --}}

@extends('main')

@section('title', $course->title)

@section('content')
<div class="container mx-auto my-8 px-4">
    <!-- Course Information Section -->
    <section class="bg-white p-6 rounded shadow">
        <h1 class="text-3xl font-bold">{{ $course->title }}</h1>
        <p class="text-gray-700 my-4">{{ $course->short_description }}</p>

        @if($course->image)
            <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded my-4">
        @endif

        <!-- What You Will Learn Section -->
        <h2 class="text-2xl font-semibold mt-8">What you will learn?</h2>
        <ul class="list-disc pl-6">
            @foreach($course->learning_points as $point)
                <li>{{ $point }}</li>
            @endforeach
        </ul>

        <h2 class="text-2xl font-semibold mt-8">Full Description</h2>
        <p class="text-gray-700">{{ $course->description }}</p>

        <!-- Start Learning Button -->
        <div class="mt-6">
            <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary">Start Learning</a>
        </div>
    </section>
</div>
@endsection


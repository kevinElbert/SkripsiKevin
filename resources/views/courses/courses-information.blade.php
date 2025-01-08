@extends('main')

@section('title', $course->title)

@section('content')
<div class="container mx-auto my-8 px-4 category-container">
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

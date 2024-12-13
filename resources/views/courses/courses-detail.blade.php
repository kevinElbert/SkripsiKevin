@extends('main')

@section('title', $course->title)

@section('content')
<div class="container mx-auto my-8 px-4 grid grid-cols-4 gap-4">
    <!-- Sub-Topic List (Kiri) -->
    <div class="col-span-1 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold">Course List</h2>
        <ul class="mt-4 space-y-2">
            @foreach($subTopics as $subTopic)
                <li>
                    <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $subTopic->id]) }}"
                       class="block p-2 rounded {{ request('subTopic') == $subTopic->id ? 'bg-blue-500 text-white' : 'text-gray-800' }}">
                        {{ $subTopic->title }}
                    </a>
                </li>
            @endforeach
        </ul>
        <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded w-full">Do Quiz</button>
        <div class="flex justify-between mt-4">
            @if($previousSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id]) }}" class="text-blue-500">Previous</a>
            @endif
        
            <!-- Tombol untuk kembali ke Main Course -->
            <a href="{{ route('courses.show', $course->slug) }}" class="text-blue-500 font-semibold">
                Back to Main Course
            </a>
        
            @if($nextSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id]) }}" class="text-blue-500">Next</a>
            @endif
        </div>
    </div>

    <!-- Video and Navigation (Tengah) -->
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold">{{ $currentSubTopic->title ?? 'Video Title' }}</h2>
        <div class="relative">
            <!-- Tombol navigasi kiri dan kanan di sekitar video -->
            <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id ?? $currentSubTopic->id]) }}"
               class="absolute left-0 top-1/2 transform -translate-y-1/2 p-2 bg-gray-200 rounded-full hover:bg-gray-300">
                &#9664;
            </a>

            <video class="w-full mt-4" controls>
                <source src="{{ $currentSubTopic->video_url ?? $course->video }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id ?? $currentSubTopic->id]) }}"
               class="absolute right-0 top-1/2 transform -translate-y-1/2 p-2 bg-gray-200 rounded-full hover:bg-gray-300">
                &#9654;
            </a>
        </div>

        <div class="flex justify-between mt-4">
            <!-- Tombol Previous -->
            <a href="{{ $previousSubTopic ? route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id]) : '#' }}"
               class="text-blue-500 {{ $previousSubTopic ? '' : 'opacity-50 cursor-not-allowed' }}">
               Previous
            </a>
        
            <!-- Tombol See Forum -->
            <a href="{{ route('forum.index', $course->id) }}" class="text-blue-500">See Forum</a>
        
            <!-- Tombol Next -->
            <a href="{{ $nextSubTopic ? route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id]) : '#' }}"
               class="text-blue-500 {{ $nextSubTopic ? '' : 'opacity-50 cursor-not-allowed' }}">
               Next
            </a>
        </div>        

        {{-- <div class="flex justify-between mt-4">
            @if($previousSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id]) }}" class="text-blue-500">Previous</a>
            @endif
            <a href="#" class="text-blue-500">See Forum</a>
            @if($nextSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id]) }}" class="text-blue-500">Next</a>
            @endif
        </div> --}}

        <div class="mt-6">
            <textarea class="w-full h-24 p-2 border rounded" placeholder="Add Notes..."></textarea>
        </div>
    </div>

    <!-- Description or Learning Text (Kanan) -->
    <div class="col-span-1 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold">What is {{ $currentSubTopic->title ?? $course->title }}?</h2>
        <p class="mt-4">
            {{ $currentSubTopic->description ?? $course->description }}
        </p>
    </div>
</div>
@endsection
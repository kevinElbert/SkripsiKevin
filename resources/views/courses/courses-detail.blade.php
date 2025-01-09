@extends('main')

@section('title', $course->title)

@vite('resources/js/tts.js')

@section('content')
{{-- Tambahkan data-course-id di div container utama --}}
<div class="container mx-auto my-8 px-4 grid grid-cols-4 gap-4 category-container" data-course-id="{{ $course->id }}">
    <!-- Sub-Topic List (Kiri) -->
    <div class="col-span-1 bg-white p-4 rounded shadow category-container">
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
        <a href="{{ route('user.quiz.show', $course->id) }}" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded w-full block text-center">
            Do Quiz
        </a>        
        <div class="flex justify-between mt-4">
            @if($previousSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id]) }}" class="text-blue-500">Previous</a>
            @endif
        
            <a href="{{ route('courses.show', $course->slug) }}" class="text-blue-500 font-semibold">
                Back to Main Course
            </a>
        
            @if($nextSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id]) }}" class="text-blue-500">Next</a>
            @endif
        </div>
    </div>

    <!-- Video and Navigation (Tengah) -->
    <div class="col-span-2 bg-white p-4 rounded shadow category-container">
        <h2 class="text-xl font-semibold">{{ $currentSubTopic->title ?? 'Video Title' }}</h2>
        <div class="relative">
            <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id ?? $currentSubTopic->id]) }}"
               class="absolute left-0 top-1/2 transform -translate-y-1/2 p-2 bg-gray-200 rounded-full hover:bg-gray-300">
                &#9664;
            </a>

            <video class="w-full mt-4" controls>
                <source src="{{ $currentSubTopic->video ?? $course->video }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id ?? $currentSubTopic->id]) }}"
               class="absolute right-0 top-1/2 transform -translate-y-1/2 p-2 bg-gray-200 rounded-full hover:bg-gray-300">
                &#9654;
            </a>
        </div>

        <div class="flex justify-between mt-4">
            <a href="{{ $previousSubTopic ? route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id]) : '#' }}"
               class="text-blue-500 {{ $previousSubTopic ? '' : 'opacity-50 cursor-not-allowed' }}">
               Previous
            </a>
        
            {{-- Perbaiki route forum untuk menggunakan parameter yang benar --}}
            <a href="{{ route('forum.index', ['course_id' => $course->id]) }}" class="text-blue-500">See Forum</a>
        
            <a href="{{ $nextSubTopic ? route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id]) : '#' }}"
               class="text-blue-500 {{ $nextSubTopic ? '' : 'opacity-50 cursor-not-allowed' }}">
               Next
            </a>
        </div>

        <!-- Notes Form -->
        <div class="mt-6">
            <form action="{{ route('notes.store') }}" method="POST">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="sub_topic_id" value="{{ $currentSubTopic->id ?? '' }}">
        
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium">Title</label>
                    <input id="title" name="title" type="text" 
                           class="w-full p-2 border border-gray-300 rounded" placeholder="Add Title...">
                </div>
        
                <textarea name="content" rows="3" 
                          class="w-full p-2 border border-gray-300 rounded" placeholder="Add Notes..."></textarea>
                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Save Note</button>
            </form>
            <a href="{{ route('notes.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">View All Notes</a>
        </div>        
    </div>

    <!-- Description or Learning Text (Kanan) -->
    <div class="col-span-1 bg-white p-4 rounded shadow category-container">
        <h2 class="text-xl font-semibold">What is {{ $currentSubTopic->title ?? $course->title }}?</h2>
        <p id="description-text" class="mt-4">
            {{ $currentSubTopic->description ?? $course->description }}
        </p>
        <button id="play-tts" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Play Audio</button>
    </div>
</div>
@endsection
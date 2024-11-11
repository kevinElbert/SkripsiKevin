@extends('main')

@section('title', $course->title)

@section('content')
<div class="container mx-auto my-8 px-4 grid grid-cols-4 gap-4">
    <!-- Sub-Topic List -->
    <div class="col-span-1 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold">Course List</h2>
        <ul class="mt-4">
            @foreach($subTopics as $subTopic)
                <li>
                    <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $subTopic->id]) }}"
                       class="block p-2 rounded {{ request('subTopic') == $subTopic->id ? 'bg-blue-500 text-white' : 'text-gray-800' }}">
                        {{ $subTopic->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Video and Navigation -->
    <div class="col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold">{{ $currentSubTopic->title ?? 'Video Title' }}</h2>
        <video class="w-full mt-4" controls>
            <source src="{{ $currentSubTopic->video_url ?? $course->video }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div class="flex justify-between mt-4">
            @if($previousSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id]) }}" class="text-blue-500">Previous</a>
            @endif
            <a href="#" class="text-blue-500">See Forum</a>
            @if($nextSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id]) }}" class="text-blue-500">Next</a>
            @endif
        </div>
    </div>

    <!-- Description or Learning Text -->
    <div class="col-span-1 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-semibold">Description</h2>
        <p class="mt-4">
            {{ $currentSubTopic->description ?? $course->description }}
        </p>
    </div>
</div>
@endsection

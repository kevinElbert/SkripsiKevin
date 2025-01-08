@extends('main')

@section('title', 'My Learning')

@section('content')
<div class="container mx-auto my-8 px-4">
    <h1 class="text-2xl font-bold mb-6">My Learning</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($courses as $course)
            <div class="category-container bg-white shadow-md rounded-lg overflow-hidden">
                <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full h-40 object-cover">
                <div class="p-4">
                    <h4 class="text-lg font-bold text-gray-800">{{ $course->title }}</h4>
                    <p class="text-gray-600 text-sm">{{ $course->short_description }}</p>

                    <div class="mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-blue-500 h-4 rounded-full" style="width: {{ $course->pivot->progress ?? 0 }}%;"></div>
                        </div>
                        <p class="text-gray-600 text-sm mt-2">Progress: {{ $course->pivot->progress ?? 0 }}%</p>
                    </div>                    
                    <div class="mt-4">
                        <a href="{{ route('courses.show', $course->slug) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-md block text-center">
                            Go to Course
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>    

    <div class="mt-6">
        {{ $courses->links() }}
    </div>
</div>
@endsection

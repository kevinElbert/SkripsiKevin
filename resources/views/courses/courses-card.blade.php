{{-- @foreach($courses as $course)
    <div class="bg-white shadow-md rounded-md p-4">
        <img src="{{ $course->image ?? '/path/to/default/image.jpg' }}" alt="{{ $course->title ?? 'Course Image' }}" class="w-full rounded-t-md">
        <h4 class="text-xl font-bold my-2">{{ $course->title ?? 'Course Title' }}</h4> --}}
        {{-- <p class="text-gray-600">{{ Str::limit($course->description, 100, '...') ?? 'No description available' }}</p> --}}
        {{-- <a href="{{ route('courses.info', $course->slug) }}" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md block text-center">Learn More</a>
        @if($isLoggedIn)
            <a href="{{ route('courses.show', $course->slug ?? 'default-slug') }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md block text-center"> Enroll</a>
        @else
            <a href="{{ route('login') }}" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md block text-center">Login to access</a>
        @endif
    </div>
@endforeach  --}}

@foreach($courses as $course)
    <div class="bg-white shadow-md rounded-md p-4">
        <img src="{{ $course->image ?? '/path/to/default/image.jpg' }}" alt="{{ $course->title ?? 'Course Image' }}" class="w-full rounded-t-md">
        
        <!-- Judul Course -->
        <h4 class="text-xl font-bold my-2">{{ $course->title ?? 'Course Title' }}</h4>
        
        <!-- Tombol untuk "Learn More" dan "Enroll" -->
        <div class="flex gap-2 mt-4">
            <a href="{{ route('courses.info', $course->slug ?? 'default-slug') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-center flex-1">
                Learn More
            </a>
            @if($isLoggedIn)
                <a href="{{ route('courses.show', $course->slug ?? 'default-slug') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-center flex-1">
                    Enroll
                </a>
            @else
                <a href="{{ route('login') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-center flex-1">
                    Login to Enroll
                </a>
            @endif
        </div>
    </div>
@endforeach


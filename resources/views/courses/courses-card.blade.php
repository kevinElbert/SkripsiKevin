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


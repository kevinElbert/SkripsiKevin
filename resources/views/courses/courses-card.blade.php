@if(isset($courses) && $courses->count() > 0)
    @foreach($courses as $course)
        <div class="bg-white shadow-md rounded-md p-4">
            <!-- Course Image -->
            <img src="{{ $course->image ?? '/path/to/default/image.jpg' }}" alt="{{ $course->title ?? 'Course Image' }}" class="w-full rounded-t-md">
            
            <!-- Course Title -->
            <h4 class="text-xl font-bold my-2">{{ $course->title ?? 'Course Title' }}</h4>
            
            <!-- Buttons: Learn More & Enroll -->
            <div class="flex gap-2 mt-4">
                <a href="{{ route('courses.info', $course->slug ?? 'default-slug') }}" tabindex="0" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-center flex-1">
                    Learn More
                </a>
                @if(Auth::check())
                    <form action="{{ route('courses.enroll', $course->slug) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md" aria-label="Enroll to {{ $course->title }}">
                            Enroll
                        </button>                    
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-center flex-1">
                        Login to Enroll
                    </a>
                @endif
            </div>
        </div>
    @endforeach
@else
    <p class="text-gray-500">No courses available for this category.</p>
@endif

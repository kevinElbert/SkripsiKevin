@foreach($courses as $course)
    <div class="bg-white shadow-md rounded-md p-4">
        <img src="{{ $course->image ?? '/path/to/default/image.jpg' }}" alt="{{ $course->title ?? 'Course Image' }}" class="w-full rounded-t-md">
        <h4 class="text-xl font-bold my-2">{{ $course->title ?? 'Course Title' }}</h4>
        <p class="text-gray-600">{{ $course->description ?? 'No description available' }}</p>
        @if($isLoggedIn)
            <a href="{{ route('courses.show', $course->slug ?? 'default-slug') }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md block text-center">Click me</a>
        @else
            <a href="{{ route('login') }}" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md block text-center">Login to access</a>
        @endif
    </div>
@endforeach 

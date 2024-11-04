{{-- @foreach($trendingCourses as $course)
    <div class="bg-white shadow-md rounded-md p-4">
        <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded-t-md">
        <h4 class="text-xl font-bold my-2">{{ $course->title }}</h4>
        <p class="text-gray-600">{{ $course->description }}</p>
        <a href="{{ route('courses.show', $course->slug) }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md block text-center">Click me</a>
    </div>
@endforeach --}}

{{-- @foreach($trendingCourses as $course)
    <div class="bg-white shadow-md rounded-md p-4">
        <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded-t-md">
        <h4 class="text-xl font-bold my-2">{{ $course->title }}</h4>
        <p class="text-gray-600">{{ $course->description }}</p>
        @if($isLoggedIn)
            <a href="{{ route('courses.show', $course->slug) }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md block text-center">Click me</a>
        @else
            <a href="{{ route('login') }}" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md block text-center">Login to access</a>
        @endif
    </div>
@endforeach --}}

{{-- <div id="course-list">
    @foreach($trendingCourses as $course)
        <div class="bg-white shadow-md rounded-md p-4 mb-4">
            <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded-t-md">
            <h4 class="text-xl font-bold my-2">{{ $course->title }}</h4>
            <p class="text-gray-600">{{ $course->description }}</p>
            <a href="{{ route('courses.show', $course->slug) }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md block text-center">Click me</a>
        </div>
    @endforeach
</div>

<button id="show-more" class="bg-gray-800 text-white px-4 py-2 rounded-md mt-4">Show More</button>

<script>
    let page = 2;
    document.getElementById('show-more').addEventListener('click', function() {
        fetch(`/load-more?page=${page}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('course-list').innerHTML += data;
            page++;
        })
        .catch(error => console.error(error));
    });
</script>
 --}}

 {{-- resources/views/partials/course-card.blade.php --}}
{{-- @if($trendingCourses->count() > 0)
@foreach($trendingCourses as $course)
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
@else
<div class="col-span-full text-center py-4">
    <p>No courses available at the moment.</p>
</div>
@endif --}}
@foreach($trendingCourses as $course)
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

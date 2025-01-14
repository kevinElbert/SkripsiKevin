@extends('main')

@section('title', 'Home Admin')

@section('content')
<main class="container mx-auto my-8 px-4">
    <!-- Introduction Section -->
    <section class="flex flex-col md:flex-row items-center justify-between p-6">
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-gray-800">Let’s learn together!</h2>
            <p class="text-gray-600 my-4">Kami percaya bahwa setiap orang, apapun kondisinya, memiliki hak yang sama untuk belajar dan berkembang. Temukan kursus yang sesuai dengan kebutuhan Anda.</p>
        </div>
        <div class="md:w-1/2 flex justify-end">
            <img src="{{ asset('build/assets/pelajardisabilitas.jpg') }}" alt="Learning Image" class="w-full md:w-auto">
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Section for Stats -->
        <aside class="w-full lg:w-1/3">
            <div class="mb-6 bg-white p-6 shadow-md rounded-md text-center border border-gray-200">
                <h3 class="text-xl font-bold mb-2">Total User Accounts</h3>
                <p class="text-2xl">{{ $totalUsers }}</p>
                <button class="mt-4 text-blue-500">⮟</button>
            </div>

            <div class="mb-6 bg-white p-6 shadow-md rounded-md text-center border border-gray-200">
                <h3 class="text-xl font-bold mb-2">Total Courses</h3>
                <p class="text-2xl">{{ $totalCourses }}</p>
                <button class="mt-4 text-blue-500">⮟</button>
            </div>

            <div class="mb-6 bg-blue-500 p-6 shadow-md rounded-md text-center border border-blue-600 hover:bg-blue-600 transition duration-200">
                <a href="{{ route('quizzes.index') }}" class="text-white text-xl font-bold">
                    Manage Quizzes
                </a>
            </div>

            {{-- <div class="mb-6 bg-green-500 p-6 shadow-md rounded-md text-center border border-green-600 hover:bg-green-600 transition duration-200">
                <a href="{{ route('forum.index', ['course_id' => 1]) }}" class="text-white text-xl font-bold">
                    Manage Forum
                </a> --}}
            {{-- </div> --}}
        </aside>

        <!-- Main Section for Courses -->
        <section class="w-full lg:w-2/3">
            <!-- Courses Section -->
            <h3 class="text-2xl font-bold text-gray-800 mb-4">My Courses!</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                @foreach($courses as $course)
                    <div class="bg-white shadow-md rounded-md p-4 border border-gray-200">
                        <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded-t-md">
                        <h4 class="text-xl font-bold my-2">{{ $course->title }}</h4>
                        <p class="text-gray-600 mb-4">{{ $course->description }}</p>
                    
                        <!-- Button Section -->
                        <div class="flex flex-wrap gap-2">
                            <!-- Edit Course -->
                            <a href="{{ route('courses.edit', $course->id) }}" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-md">Edit Course</a>
                    
                            <!-- Delete Course -->
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                            </form>
                    
                            <!-- Create Quiz -->
                            <a href="{{ route('quizzes.create', $course->id) }}" 
                            class="bg-green-600 text-white px-4 py-2 rounded-md">Create Quiz</a>
                    
                            <!-- Edit Quiz -->
                            @if ($course->quizzes->count() > 0)
                                <a href="{{ route('quizzes.edit', $course->quizzes->first()->id) }}" 
                                class="bg-yellow-600 text-white px-4 py-2 rounded-md">Edit Quiz</a>
                            @endif

                                <!-- Tombol Manage Forum -->
                            <a href="{{ route('forum.index', $course->id) }}" 
                                class="bg-purple-600 text-white px-4 py-2 rounded-md">Manage Forum</a>
                        </div>
                    </div>                
                @endforeach
            </div>
            
            <!-- Move Pagination Outside of the Grid -->
            <div class="mt-6">
                {{ $courses->links() }} <!-- Pagination links -->
            </div> 

            <!-- Create Button -->
            <div class="text-center mt-8">
                <!-- Tambahkan route untuk halaman create -->
                <a href="{{ route('courses.create') }}" class="bg-blue-500 text-white p-4 rounded-full shadow-md">
                    <i class="fas fa-plus"></i> Create
                </a>
            </div>
        </section>
    </section>
</main>
@endsection

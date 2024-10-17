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

            <div class="mb-6 bg-white p-6 shadow-md rounded-md text-center border border-gray-200">
                <h3 class="text-xl font-bold mb-2">Score Average</h3>
                <ul class="text-left">
                    <li>Indonesian: 85.23</li>
                    <li>Chemistry: 92.30</li>
                    <li>Mathematics: 78.48</li>
                </ul>
                <button class="mt-4 text-blue-500">⮟</button>
            </div>

            <div class="mb-6 bg-white p-6 shadow-md rounded-md text-center border border-gray-200">
                <h3 class="text-xl font-bold mb-2">Course File Size</h3>
                <ul class="text-left">
                    <li>Indonesian: 23gb</li>
                    <li>Chemistry: 828mb</li>
                    <li>Mathematics: 48tb</li>
                </ul>
                <button class="mt-4 text-blue-500">⮟</button>
            </div>
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
                        <p class="text-gray-600">{{ $course->description }}</p>
                        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Edit ⮟</button>
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

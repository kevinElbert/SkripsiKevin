@extends('main')

@section('title', 'Home Admin')

@section('content')
<main class="container mx-auto my-8 px-4">
    <!-- Introduction Section -->
    <section class="flex flex-col md:flex-row items-center justify-between p-6">
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-gray-800">Let’s learn together!</h2>
            <p class="text-gray-600 my-4">Kami percaya bahwa setiap orang, apapun kondisinya, memiliki hak yang sama untuk belajar dan berkembang. Temukan kursus yang sesuai dengan kebutuhan Anda.</p>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">CRUD Button</button>
        </div>
        <div class="md:w-1/2 flex justify-end">
            <img src="{{ asset('build/assets/pelajardisabilitas.jpg') }}" alt="Learning Image" class="w-full md:w-auto">
        </div>
    </section>

    <!-- Dashboard Section -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-4 shadow-md rounded-md text-center">
            <h3 class="text-xl font-bold mb-2">Total User Accounts</h3>
            <p class="text-2xl">{{ $totalUsers }}</p>
            <button class="mt-4 text-blue-500">⮟</button>
        </div>
        <div class="bg-white p-4 shadow-md rounded-md text-center">
            <h3 class="text-xl font-bold mb-2">Total Courses</h3>
            <p class="text-2xl">{{ $totalCourses }}</p>
            <button class="mt-4 text-blue-500">⮟</button>
        </div>
        <div class="bg-white p-4 shadow-md rounded-md text-center">
            <h3 class="text-xl font-bold mb-2">Score Average</h3>
            <ul class="text-left">
                <li>Indonesian: 85.23</li>
                <li>Chemistry: 92.30</li>
                <li>Mathematics: 78.48</li>
            </ul>
            <button class="mt-4 text-blue-500">⮟</button>
        </div>
        <div class="bg-white p-4 shadow-md rounded-md text-center">
            <h3 class="text-xl font-bold mb-2">Course File Size</h3>
            <ul class="text-left">
                <li>Indonesian: 23gb</li>
                <li>Chemistry: 828mb</li>
                <li>Mathematics: 48tb</li>
            </ul>
            <button class="mt-4 text-blue-500">⮟</button>
        </div>
    </section>

    <!-- Courses Section -->
    <section class="my-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Kursus lagi trend!</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- @foreach($trendingCourses as $course)
                    <div class="bg-white shadow-md rounded-md p-4">
                        <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded-t-md">
                        <h4 class="text-xl font-bold my-2">{{ $course->title }}</h4>
                        <p class="text-gray-600">{{ $course->description }}</p>
                        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Edit ⮟</button>
                    </div>
                @endforeach --}}
        </div>
        <div class="text-center mt-6">
            <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Show More</button>
        </div>
    </section>

    <!-- Promosi Kursus Section -->
    <section class="my-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Promosi Kursus</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- @foreach($promotedCourses as $course)
                <div class="bg-white shadow-md rounded-md p-4">
                    <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded-t-md">
                    <h4 class="text-xl font-bold my-2">{{ $course->title }}</h4>
                    <p class="text-gray-600">{{ $course->description }}</p>
                    <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Edit ⮟</button>
                </div>
            @endforeach --}}
        </div>
        <div class="text-center mt-6">
            <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Show More</button>
        </div>
    </section>
</main>
@endsection

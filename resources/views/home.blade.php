@extends('main')

@section('Home', 'Home Page')

@section('content')
<!-- Main Section -->
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

    <!-- Search Bar and Filters -->
    <section class="text-center my-6">
        <input type="text" placeholder="What do you want to learn?" class="w-full max-w-xl border border-gray-300 rounded-md p-2">
        <p class="text-gray-600 my-2">Pilih filter kursus sesuai dengan kebutuhan kondisi Anda!</p>
        <div class="space-x-2 my-4">
            <button class="bg-blue-500 text-black px-4 py-2 rounded-full">Deaf</button>
            <button class="bg-blue-500 text-black px-4 py-2 rounded-full">Visually Impaired</button>
            <button class="bg-blue-500 text-black px-4 py-2 rounded-full">Intellectual</button>
            <button class="bg-blue-500 text-black px-4 py-2 rounded-full">Others</button>
        </div>
    </section>

    <!-- Trending Courses Section -->
    <section class="my-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Kursus lagi trend!</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($trendingCourses as $course)
                <div class="bg-white shadow-md rounded-md p-4">
                    <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded-t-md">
                    <h4 class="text-xl font-bold my-2">{{ $course->title }}</h4>
                    <p class="text-gray-600">{{ $course->description }}</p>
                    <button class="mt-4 bg-blue-600 text-black px-4 py-2 rounded-md">Click me</button>
                </div>
            @endforeach
        </div>
        <!-- Tambahkan pagination link -->
        <div class="mt-6">
            {{ $trendingCourses->links() }}
        </div>
    </section> 

     <!-- Best Courses for Deaf Section -->
     <section class="my-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Kursus untuk meninkatkan pengetahuan dasar!</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($bestCoursesDeaf as $course)
                <div class="bg-white shadow-md rounded-md p-4">
                    <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded-t-md">
                    <h4 class="text-xl font-bold my-2">{{ $course->title }}</h4>
                    <p class="text-gray-600">{{ $course->description }}</p>
                    <button class="mt-4 bg-blue-600 text-black px-4 py-2 rounded-md">Click me</button>
                </div>
            @endforeach
        </div>
        <!-- Tambahkan pagination link -->
        <div class="mt-6">
            {{ $bestCoursesDeaf->links() }}
        </div>
    </section> 

    <!-- Explore Courses Section -->
    <section class="my-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Kursus untuk disabilitas!</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($visitedCourses as $course)
                <div class="bg-white shadow-md rounded-md p-4">
                    <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full rounded-t-md">
                    <h4 class="text-xl font-bold my-2">{{ $course->title }}</h4>
                    <p class="text-gray-600">{{ $course->description }}</p>
                    <button class="mt-4 bg-blue-600 text-black px-4 py-2 rounded-md">Click me</button>
                </div>
            @endforeach
        </div>
        <!-- Tambahkan pagination link -->
        <div class="mt-6">
            {{ $visitedCourses->links() }}
        </div>
    </section> 
</main>
@endsection

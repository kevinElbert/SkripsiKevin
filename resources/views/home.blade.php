@extends('main')

@section('Home', 'Home Page')

@section('content')
@vite(['resources/js/loadMoreCourses.js'])
<main class="container mx-auto my-8 px-4">
    <!-- Introduction Section -->
    <section class="flex flex-col md:flex-row items-center justify-between p-6 mb-12">
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-gray-800">Let’s learn together!</h2>
            <p class="text-gray-600 my-4">Kami percaya bahwa setiap orang, apapun kondisinya, memiliki hak yang sama untuk belajar dan berkembang. Temukan kursus yang sesuai dengan kebutuhan Anda.</p>
        </div>
        <div class="md:w-1/2 flex justify-end">
            <img src="{{ asset('build/assets/pelajardisabilitas.jpg') }}" alt="Learning Image" class="w-full md:w-auto rounded-lg shadow-md">
        </div>
    </section>

    <!-- Trending Courses Section -->
    <section class="my-12 bg-gray-50 p-6 rounded-lg shadow-sm">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Kursus lagi trend!</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="trending-courses-container">
            @include('course-card', ['courses' => $trendingCourses])
        </div>
        <div class="mt-6 text-center">
            <button id="show-more-trending" class="bg-gray-300 text-black px-4 py-2 rounded-md hover:bg-gray-400">Show More</button>
        </div>
    </section>

    <!-- Best Courses for Deaf Section -->
    <section class="my-12 bg-gray-50 p-6 rounded-lg shadow-sm">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Kursus untuk meningkatkan pengetahuan dasar!</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="deaf-courses-container">
            @include('course-card', ['courses' => $bestCoursesDeaf])
        </div>
        <div class="mt-6 text-center">
            <button id="show-more-deaf" class="bg-gray-300 text-black px-4 py-2 rounded-md hover:bg-gray-400">Show More</button>
        </div>
    </section>

    <!-- Explore Courses Section -->
    <section class="my-12 bg-gray-50 p-6 rounded-lg shadow-sm">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Kursus untuk disabilitas!</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="disability-courses-container">
            @include('course-card', ['courses' => $visitedCourses])
        </div>
        <div class="mt-6 text-center">
            <button id="show-more-disability" class="bg-gray-300 text-black px-4 py-2 rounded-md hover:bg-gray-400">Show More</button>
        </div>
    </section>
</main>
@endsection

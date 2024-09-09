@extends('main')

@section('Home', 'Login')

@section('content')

<!-- Main Section -->
<main class="container mx-auto my-8 px-4">
        <section class="text-center">
            <h2 class="text-3xl font-bold text-gray-800">Let’s learn together!</h2>
            <p class="text-gray-600 my-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <div class="flex justify-center">
                <img src="path/to/image.jpg" alt="Learning Image" class="w-1/2">
            </div>
            <div class="my-4">
                <input type="text" placeholder="What do you want to learn?" class="w-full border border-gray-300 rounded-md p-2">
            </div>
            <p class="text-gray-600 my-2">Pilih filter kursus sesuai dengan kebutuhan kondisi Anda!</p>
            <div class="space-x-2 my-4">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Deaf</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Visually Impaired</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Intellectual</button>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Others</button>
            </div>
        </section>

        <!-- Trending Courses Section -->
        <section class="my-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Kursus lagi trend!</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Course Card 1 -->
                <div class="bg-white shadow-md rounded-md p-4">
                    <img src="path/to/course1.jpg" alt="Course Image" class="w-full rounded-t-md">
                    <h4 class="text-xl font-bold my-2">Mathematics</h4>
                    <p class="text-gray-600">Mathematics yang trend</p>
                    <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
                </div>
                <!-- Course Card 2 -->
                <div class="bg-white shadow-md rounded-md p-4">
                    <img src="path/to/course2.jpg" alt="Course Image" class="w-full rounded-t-md">
                    <h4 class="text-xl font-bold my-2">Information Tech</h4>
                    <p class="text-gray-600">Information Tech yang lagi booming</p>
                    <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
                </div>
                <!-- Course Card 3 -->
                <div class="bg-white shadow-md rounded-md p-4">
                    <img src="path/to/course3.jpg" alt="Course Image" class="w-full rounded-t-md">
                    <h4 class="text-xl font-bold my-2">Chemistry</h4>
                    <p class="text-gray-600">Belajar chemistry dengan mudah</p>
                    <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
                </div>
            </div>
            <div class="text-center mt-6">
                <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Show More</button>
            </div>
        </section>

        <!-- Best Courses for Deaf Section -->
        <section class="my-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Pelajaran terbaik untuk Disabilitas Rungu</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Repeat the same course cards as above -->
                <!-- You can duplicate the same layout for each course card -->
            </div>
            <div class="text-center mt-6">
                <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Show More</button>
            </div>
        </section>

        <!-- Explore Courses Section -->
        <section class="my-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Explore course you have visited!</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Repeat the same course cards -->
            </div>
            <div class="text-center mt-6">
                <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Show More</button>
            </div>
        </section>
    </main>


@endsection
@extends('main')

@section('Home', 'Login')

@section('content')

<!-- Main Section -->
<main class="container mx-auto my-8 px-4">
    <!-- Introduction Section -->
<section class="flex flex-col md:flex-row items-center justify-between p-6">
    <!-- Text Section -->
    <div class="md:w-1/2 md:order-1 order-2">
        <h2 class="text-3xl font-bold text-gray-800">Let’s learn together!</h2>
        <p class="text-gray-600 my-4">Kami percaya bahwa setiap orang, apapun kondisi dan kebutuhannya, memiliki hak yang sama untuk belajar dan berkembang. Temukan kursus yang disesuaikan untuk Anda, dengan konten yang ramah dan mudah diakses, sehingga Anda dapat mencapai potensi terbaik Anda.</p>
    </div>

    <!-- Image Section -->
    <div class="md:w-1/2 md:order-2 order-1 flex justify-end">
        <img src="{{ asset('build/assets/disabilitasbelajar.jpg') }}" alt="Learning Image" class="w-full md:w-auto md:ml-auto">
    </div>
</section>

    <!-- Search Bar and Filters -->
    <section class="text-center my-6">
        <input type="text" placeholder="What do you want to learn?" class="w-full max-w-xl border border-gray-300 rounded-md p-2">
        <p class="text-gray-600 my-2">Pilih filter kursus sesuai dengan kebutuhan kondisi Anda!</p>
        <div class="space-x-2 my-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded-full">Deaf</button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-full">Visually Impaired</button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-full">Intellectual</button>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-full">Others</button>
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
            <div class="bg-white shadow-md rounded-md p-4">
                <img src="path/to/course1.jpg" alt="Course Image" class="w-full rounded-t-md">
                <h4 class="text-xl font-bold my-2">Mathematics</h4>
                <p class="text-gray-600">Mathematics yang trend</p>
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
            </div>
            <div class="bg-white shadow-md rounded-md p-4">
                <img src="path/to/course1.jpg" alt="Course Image" class="w-full rounded-t-md">
                <h4 class="text-xl font-bold my-2">Mathematics</h4>
                <p class="text-gray-600">Mathematics yang trend</p>
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
            </div>
            <!-- Repeat more course cards as needed -->
        </div>
        <div class="text-center mt-6">
            <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Show More</button>
        </div>
    </section>

    <!-- Best Courses for Deaf Section -->
    <section class="my-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Pelajaran terbaik untuk Disabilitas Rungu</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Course Card 2 -->
            <div class="bg-white shadow-md rounded-md p-4">
                <img src="path/to/course1.jpg" alt="Course Image" class="w-full rounded-t-md">
                <h4 class="text-xl font-bold my-2">Mathematics</h4>
                <p class="text-gray-600">Mathematics yang trend</p>
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
            </div>
            <div class="bg-white shadow-md rounded-md p-4">
                <img src="path/to/course1.jpg" alt="Course Image" class="w-full rounded-t-md">
                <h4 class="text-xl font-bold my-2">Mathematics</h4>
                <p class="text-gray-600">Mathematics yang trend</p>
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
            </div>
            <div class="bg-white shadow-md rounded-md p-4">
                <img src="path/to/course1.jpg" alt="Course Image" class="w-full rounded-t-md">
                <h4 class="text-xl font-bold my-2">Mathematics</h4>
                <p class="text-gray-600">Mathematics yang trend</p>
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
            </div>
        </div>
        
        <div class="text-center mt-6">
            <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Show More</button>
        </div>
    </section>

    <!-- Explore Courses Section -->
    <section class="my-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Explore course you have visited!</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Course Card 3 -->
            <div class="bg-white shadow-md rounded-md p-4">
                <img src="path/to/course1.jpg" alt="Course Image" class="w-full rounded-t-md">
                <h4 class="text-xl font-bold my-2">Mathematics</h4>
                <p class="text-gray-600">Mathematics yang trend</p>
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
            </div>
            <div class="bg-white shadow-md rounded-md p-4">
                <img src="path/to/course1.jpg" alt="Course Image" class="w-full rounded-t-md">
                <h4 class="text-xl font-bold my-2">Mathematics</h4>
                <p class="text-gray-600">Mathematics yang trend</p>
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
            </div>
            <div class="bg-white shadow-md rounded-md p-4">
                <img src="path/to/course1.jpg" alt="Course Image" class="w-full rounded-t-md">
                <h4 class="text-xl font-bold my-2">Mathematics</h4>
                <p class="text-gray-600">Mathematics yang trend</p>
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Click me</button>
            </div>
        </div>
        <div class="text-center mt-6">
            <button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md">Show More</button>
        </div>
    </section>
</main>

@endsection
@extends('main')

@section('title', 'Home Page')

@section('content')
<main class="container mx-auto my-8 px-4">
    <!-- Introduction Section -->
    <section class="flex flex-col md:flex-row items-center justify-between p-6 mb-12">
        <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-gray-800">Let’s learn together!</h2>
            <p class="text-gray-600 my-4">Kami percaya bahwa setiap orang, apapun kondisinya, memiliki hak yang sama untuk belajar dan berkembang. Temukan kursus yang sesuai dengan kebutuhan Anda.</p>
        </div>
        <div class="md:w-1/2 flex justify-end">
            <!-- Ubah ukuran gambar di sini -->
            <img src="{{ asset('HomeUserDisabilityLearn.png') }}" 
                 alt="Learning Image" 
                 class="w-72 h-auto rounded-lg shadow-md">
        </div>
    </section>

    <!-- Dynamic Sections Based on Categories -->
    @foreach($categories as $category)
        <section class="my-12 bg-gray-50 p-6 rounded-lg shadow-sm category-container">
            <h3 class="text-2xl font-bold mb-4">{{ $category->name }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @include('courses.courses-card', ['courses' => $category->courses->take(3)])
            </div>
            @if($category->courses->count() > 3)
                <div class="mt-6 text-center">
                    <button id="show-more-category-{{ $category->id }}" 
                            data-category-id="{{ $category->id }}" 
                            data-page="2" 
                            class="bg-gray-300 text-black px-4 py-2 rounded-md hover:bg-gray-400">
                        Show More
                    </button>
                </div>
            @endif
        </section>
    @endforeach
</main>
@endsection

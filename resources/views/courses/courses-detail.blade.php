@extends('main')

@section('title', $course->title)

@section('content')
<main class="container mx-auto my-8 px-4">
    <!-- Specific Course Section -->
    <section class="flex flex-col md:flex-row gap-4">
        <!-- Sidebar for Topics -->
        <aside class="w-full md:w-1/4 bg-white shadow-md rounded-md p-4">
            <h3 class="text-xl font-bold mb-4">Topic List</h3>
            <ul>
                <li class="mb-4">
                    <img src="{{ asset('placeholder-topic-image.jpg') }}" alt="Topic Image" class="w-full mb-2">
                    <h4 class="font-bold">Introduction to C</h4>
                    <p>Pengenalan apa itu C?</p>
                </li>
                <!-- Tambahkan lebih banyak topic sesuai course -->
                <li class="mb-4">
                    <img src="{{ asset('placeholder-topic-image.jpg') }}" alt="Topic Image" class="w-full mb-2">
                    <h4 class="font-bold">Topic Title 3</h4>
                    <p>Short Description</p>
                </li>
            </ul>
            <div class="mt-6">
                <a href="#" class="block bg-blue-600 text-white text-center py-2 rounded-md">Quiz</a>
            </div>
        </aside>

        <!-- Main Course Content -->
        <div class="w-full md:w-3/4">
            <!-- Video Section -->
            <div class="video-wrapper bg-black mb-6">
                <video width="100%" controls>
                    <source src="{{ $course->video }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

            <!-- Course Description Section -->
            <div class="course-content bg-white shadow-md rounded-md p-4">
                <h2 class="text-3xl font-bold">{{ $course->title }}</h2>
                <p class="mt-4">{{ $course->description }}</p>

                <!-- Content Example -->
                <div class="mt-6">
                    <pre>
#include &lt;stdio.h&gt;

int main() {
    char karakter;
    karakter = 'A';
    printf("Karakter pertama adalah %c", karakter);
    karakter = 'B';
    printf("Karakter kedua adalah %c", karakter);
    karakter = 'C';
    printf("Karakter ketiga adalah %c", karakter);
}
                    </pre>
                </div>

                <div class="mt-6">
                    <p>Gambar di atas ialah contoh bahasa pemrograman C dengan sintaks variabel dan nilai. Lorem ipsum dolor sit amet...</p>
                </div>

                <!-- References Section -->
                <div class="mt-12">
                    <h3 class="text-2xl font-bold">References</h3>
                    <ul class="list-disc ml-6">
                        <li>Sumber: HI Edukasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

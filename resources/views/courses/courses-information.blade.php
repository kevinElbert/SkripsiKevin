@extends('main')

@section('title', $course->title)

@section('content')
<div class="container mx-auto my-8 px-4">
    <!-- Hero Section with Gradient Background -->
    <section class="relative bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow-xl overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 p-8 md:p-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $course->title }}</h1>
            <p class="text-xl text-white/90 max-w-2xl">{{ $course->short_description }}</p>
        </div>
    </section>

    <!-- Main Content Grid -->
    <div class="grid md:grid-cols-3 gap-8 mt-8">
        <!-- Left Content -->
        <div class="md:col-span-2">
            @if($course->image)
                <div class="rounded-lg overflow-hidden shadow-lg mb-8 transition-transform hover:scale-[1.02]">
                    <img src="{{ $course->image }}" alt="{{ $course->title }}" class="w-full h-[400px] object-cover">
                </div>
            @endif

            <!-- What You Will Learn Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    What you will learn
                </h2>
                <div class="grid md:grid-cols-2 gap-4">
                    @foreach($course->learning_points as $point)
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <p class="text-gray-700">{{ $point }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Full Description Section -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Full Description</h2>
                <p class="text-gray-700 leading-relaxed">{{ $course->description }}</p>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6 sticky top-4">
                <div class="space-y-4">
                    <div class="flex items-center text-lg font-semibold text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Course Duration: 8 weeks
                    </div>
                    <div class="flex items-center text-lg font-semibold text-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Skill Level: Beginner
                    </div>
                    
                    @auth
                        <a href="{{ route('courses.show', $course->slug) }}" 
                           class="block w-full py-3 px-4 text-center text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-200 font-semibold">
                            Start Learning
                        </a>
                    @else
                        <button onclick="showLoginModal()" 
                                class="block w-full py-3 px-4 text-center text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-200 font-semibold">
                            Start Learning
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-8 max-w-md w-full m-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-900">Login Required</h3>
            <button onclick="hideLoginModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <p class="text-gray-600 mb-6">Please log in to access this course.</p>
        <div class="flex space-x-4">
            <a href="{{ route('login') }}" class="flex-1 py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-center transition duration-200">
                Log In
            </a>
            <a href="{{ route('register') }}" class="flex-1 py-2 px-4 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-center transition duration-200">
                Register
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showLoginModal() {
        const modal = document.getElementById('loginModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideLoginModal() {
        const modal = document.getElementById('loginModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close modal when clicking outside
    document.getElementById('loginModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideLoginModal();
        }
    });
</script>
@endpush
@endsection
<header class="bg-gray-800 p-4 flex flex-col sm:flex-row sm:justify-between sm:items-center">
    <!-- Logo and Name -->
    <div class="flex items-center justify-center sm:justify-start mb-4 sm:mb-0">
        <h3 class="text-white text-3xl font-bold">DisabilityLearn</h3>
    </div>

    <!-- Navigation Links -->
    <nav class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-4">
        <a href="{{ route('courses.mylearning') }}" class="flex items-center text-white hover:text-purple-300">
            <i class="fas fa-graduation-cap mr-2"></i> MyLearning
        </a>
        <a href="{{ Auth::check() ? (Auth::user()->usertype === 'admin' ? route('dashboard') : route('home')) : '/' }}" class="flex items-center text-white hover:text-purple-300">
            <i class="fas fa-house-chimney mr-2"></i> Home
        </a>
        <a href="{{ route('notes.index') }}" class="flex items-center text-white hover:text-purple-300">
            <i class="fas fa-sticky-note mr-2"></i> Notes
        </a>
        <a href="#footer" class="flex items-center text-white hover:text-purple-300">
            <i class="fa-solid fa-info mr-2"></i> About us
        </a>
    </nav>

    <!-- User Profile or Login/Register -->
    <div class="flex items-center space-x-4 mt-4 sm:mt-0">
        @guest
            <a href="{{ route('login') }}" class="text-white hover:text-purple-300">Login</a>
            <a href="{{ route('register') }}" class="text-white hover:text-purple-300">Register</a>
        @endguest

        @auth
            <span class="mr-2 text-white">Hi, {{ Auth::user()->name }}</span>
            <a href="{{ route('profile.edit') }}">
                <i class="fas fa-user text-white"></i>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-white hover:text-purple-300">Logout</button>
            </form>
        @endauth
    </div>
</header>

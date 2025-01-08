<header class="bg-gray-800 p-4 flex flex-wrap items-center justify-between space-y-2 sm:space-y-0">
    <!-- Logo -->
    <div class="flex items-center">
        <h3 class="text-white text-2xl font-bold">DisabilityLearn</h3>
    </div>

    <!-- Navigation Links -->
    <nav class="flex flex-wrap items-center space-x-4">
        <a href="{{ route('courses.mylearning') }}" class="flex items-center px-3 py-2 rounded-md {{ request()->routeIs('courses.mylearning') ? 'bg-purple-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <i class="fas fa-graduation-cap mr-2"></i> MyLearning
        </a>
        <a href="{{ Auth::check() ? (Auth::user()->usertype === 'admin' ? route('dashboard') : route('home')) : '/' }}" 
           class="flex items-center px-3 py-2 rounded-md {{ request()->routeIs('home') ? 'bg-purple-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <i class="fas fa-house-chimney mr-2"></i> Home
        </a>
        <a href="{{ route('notes.index') }}" class="flex items-center px-3 py-2 rounded-md {{ request()->routeIs('notes.index') ? 'bg-purple-500 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            <i class="fas fa-sticky-note mr-2"></i> Notes
        </a>
        <a href="#footer" class="flex items-center px-3 py-2 rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            <i class="fa-solid fa-info mr-2"></i> About us
        </a>
    </nav>

    <!-- High Contrast Toggle -->
    <div class="flex items-center space-x-4">
        <button id="toggle-high-contrast" class="bg-yellow-500 text-black px-4 py-2 rounded-md hover:bg-yellow-600">
            Toggle High Contrast
        </button>
    </div>

    <!-- User Profile or Login/Register -->
    <div class="flex items-center space-x-4">
        @guest
            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">Login</a>
            <a href="{{ route('register') }}" class="text-gray-300 hover:text-white">Register</a>
        @endguest

        @auth
            <span class="text-white">Hi, {{ Auth::user()->name }}</span>
            <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white">
                <i class="fas fa-user"></i>
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-gray-300 hover:text-white">Logout</button>
            </form>
        @endauth
    </div>
</header>

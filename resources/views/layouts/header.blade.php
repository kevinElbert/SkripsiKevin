
<header class="bg-gray-800 p-4">
    <div class="flex justify-between items-center text-purple-300">
        <!-- Logo and Name -->
        <div class="flex items-center">
            <h3 class="text-white text-3xl font-bold">DisabilityLearn</h3>
        </div>

        <!-- Navigation Links -->
        <nav class="flex items-center space-x-4 justify-center">
            <a href="/mylearning" class="flex items-center text-white hover:text-purple-300">
                <i class="fas fa-graduation-cap mr-2"></i> MyLearning
            </a>
            
            <a href="/" class="flex items-center text-white hover:text-purple-300">
                <i class="fas fa-house-chimney mr-2"></i> Home
            </a>
            <a href="#footer" class="flex items-center text-white hover:text-purple-300">
                <i class="fa-solid fa-info mr-2"></i> About us
            </a>
        </nav>

        <!-- User Profile or Login/Register -->
        <div class="flex items-center space-x-4">
            <!-- Jika user belum login, tampilkan Login/Register -->
            @guest
                <a href="{{ route('login') }}" class="text-white hover:text-purple-300">Login</a>
                <a href="{{ route('register') }}" class="text-white hover:text-purple-300">Register</a>
            @endguest

            <!-- Jika user sudah login, tampilkan nama user dan icon profil -->
            @auth
                <span class="mr-2 text-white">Hi, {{ Auth::user()->name }}</span>
                <a href="{{ route('profile.edit') }}">
                    <i class="fas fa-user text-white"></i>
                </a>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-white hover:text-purple-300">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</header>

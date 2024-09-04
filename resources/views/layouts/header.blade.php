<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Header</title>
    @vite('resources/css/app.css')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>
<body>
    <header class="bg-gray-800 p-4">
        <div class="flex justify-between items-center text-purple-300">
            <!-- Logo and Name -->
            <div class="flex items-center">
                <h3 class="text-white text-3xl font-bold">DisabilityLearn</h3>
            </div>
    
            <!-- Navigation Links -->
            <nav class="flex items-center space-x-4">
                <a href="/mylearning" class="flex items-center text-purple-300 hover:text-white">
                    MyLearning <img src="path_to_mylearning_icon" alt="MyLearning" class="ml-1 w-4 h-4">
                </a>
                <a href="/" class="flex items-center text-white hover:text-purple-300">
                    Home <img src="path_to_home_icon" alt="Home" class="ml-1 w-4 h-4">
                </a>
                <a href="/about" class="flex items-center text-white hover:text-purple-300">
                    About us <img src="path_to_about_icon" alt="About us" class="ml-1 w-4 h-4">
                </a>
            </nav>
    
            <!-- User Profile -->
            <div class="flex items-center">
                <span class="mr-2 text-purple-300">Hi, user01</span>
                <img src="path_to_user_icon" alt="User Profile" class="w-6 h-6">
            </div>
        </div>
    </header>
</body>
</html>
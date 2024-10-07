<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Header</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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
                <a href="/mylearning" class="flex items-center text-white hover:text-purple-300">
                    MyLearning <i class="fas fa-graduation-cap ml-2"></i>
                </a>
                
                <a href="/" class="flex items-center text-white hover:text-purple-300">
                    Home <i class="fas fa-house-chimney ml-2"></i>
                </a>
                <a href="/about" class="flex items-center text-white hover:text-purple-300">
                    About us <i class="fa-solid fa-info ml-2"></i>
                </a>
            </nav>
    
            <!-- User Profile -->
            <div class="flex items-center">
                <span class="mr-2 text-white">Hi, user01</span>
                <i class="fas fa-user text-white"></i>
            </div>
        </div>
    </header>
</body>
</html>

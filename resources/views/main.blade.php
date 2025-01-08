<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Importing Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Additional Scripts Based on Route -->
    @if(request()->routeIs('courses.index') || request()->routeIs('courses.show')) 
        @vite('resources/js/loadMoreCourses.js')
    @endif
    @vite('resources/js/coursesFilter.js')
    @vite('resources/js/modalHandler.js')
    @vite('resources/js/likeHandler.js')

    <!-- Importing Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="min-h-screen flex flex-col">
    <!-- Including Header -->
    @include('layouts.header')

    <main class="flex-grow">
        <!-- Content Section Yield -->
        @yield('content')
    </main>

    <!-- Including Footer -->
    @include('layouts.footer')

    @stack('scripts')
</body>
</html>

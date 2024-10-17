<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <!-- Importing Tailwind CSS -->
    @vite('resources/css/app.css')
    <!-- Importing Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Including Header -->
    @include('layouts.header')

    <div class="content">
        <!-- Content Section Yield -->
        @yield('content')
    </div>

    <!-- Including Footer -->
    @include('layouts.footer')
</body>
</html>

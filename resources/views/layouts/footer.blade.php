<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Footer</title>
    @vite('resources/css/app.css')
</head>
<body>
    <!-- resources/views/partials/footer.blade.php -->
<footer class="bg-gray-800 text-purple-300 p-4">
    <div class="flex justify-between items-center">
        <!-- Logo and Name -->
        <div class="flex items-center">
            <div>
                <h3 class="text-white text-4xl font-bold">DisabilityLearn</h3>
                <p class="text-gray-400">(c) 2024 DisabilityLearn, Inc.</p>
            </div>
        </div>

        <div class="border-l border-white h-20 mx-2"></div>

        <!-- University Information -->
        <div class="text-white">
            <h4 class="text-2xl font-bold">Bina Nusantara University</h4>
            <p class="text-gray-400 text-lg">
                Jl. Raya Kb. Jeruk No.27, RT.1/RW.9, Kemanggisan, Kec. Palmerah, 
                Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11530
            </p>
        </div>

        <div class="border-l border-white h-20 mx-2"></div>

        <!-- Contact Us -->
        <div class="text-right">
            <h4 class="text-2xl font-bold text-white flex mr-4">Contact Us</h4>
            <div class="flex flex-col items-end mt-2 space-y-2">
                <div class="flex space-x-4 mr-8">
                    <a href="#" class="text-purple-300 hover:text-white">
                        <img src="{{ asset('build/assets/instagram.png') }}" alt="Instagram" class="w-5 h-5">
                    </a>
                    <a href="#" class="text-purple-300 hover:text-white">
                        <img src="{{ asset('build/assets/gmail.png') }}" alt="Email" class="w-5 h-5">
                    </a>
                    <a href="#" class="text-purple-300 hover:text-white">
                        <img src="{{ asset('build/assets/logo.png') }}" alt="WhatsApp" class="w-5 h-5">
                    </a>
                </div>
                <div class="flex space-x-4 mr-8">
                    <a href="#" class="text-purple-300 hover:text-white">
                        <img src="{{ asset('build/assets/twitter.png') }}" alt="Twitter" class="w-5 h-5">
                    </a>
                    <a href="#" class="text-purple-300 hover:text-white">
                        <img src="{{ asset('build/assets/youtube.png') }}" alt="YouTube" class="w-5 h-5">
                    </a>
                    <a href="#" class="text-purple-300 hover:text-white">
                        <img src="{{ asset('build/assets/facebook.png') }}" alt="FaceBook" class="w-5 h-5">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
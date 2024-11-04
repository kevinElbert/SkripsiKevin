@extends('main')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900">
    <div class="w-full max-w-md bg-gradient-to-r from-gray-800 via-gray-900 to-gray-800 p-8 rounded-lg shadow-lg shadow-blue-900 text-white">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('build/assets/LogoDisability.png') }}" alt="Disability Learn Logo" class="w-16 h-16 animate-pulse">
        </div>
        <h2 class="text-center text-3xl font-extrabold mb-4">Welcome to Disability Learn!</h2>

        <!-- Komponen Breeze untuk Form Login -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-300"/>
                <x-text-input id="email" class="block mt-1 w-full bg-gray-700 text-gray-300 placeholder-gray-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-300"/>
                <x-text-input id="password" class="block mt-1 w-full bg-gray-700 text-gray-300 placeholder-gray-500" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 bg-gray-700 text-indigo-500 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Button & Forgot Password Link -->
            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-blue-400 hover:text-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button class="ml-3 bg-blue-600 hover:bg-blue-700 transform hover:scale-105 transition duration-150 ease-in-out">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- @extends('main')

@section('title', 'Login')

@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endsection
 --}}

 @extends('main')

@section('title', 'Profile')

@section('content')
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto py-12 px-6 space-y-6">
            <!-- Update Profile Information -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            <div class="p-6 bg-red-50 dark:bg-red-900 shadow-md rounded-lg">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection


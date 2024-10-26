@extends('main')

@section('title', 'Create Course')

@section('content')
<main class="container mx-auto my-8 px-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Create New Course</h2>

    <!-- Form untuk create course -->
    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-md shadow-md">
        @csrf <!-- Laravel CSRF protection -->

        <!-- Input untuk Course Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Course Title</label>
            <input type="text" name="title" id="title" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <!-- Input untuk Course Description -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Course Description</label>
            <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
        </div>

        <!-- Input untuk Upload Video -->
        <div class="mb-4">
            <label for="video" class="block text-gray-700">Upload Course Video</label>
            <input type="file" name="video" id="video" accept="video/*" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <!-- Input untuk Upload Gambar -->
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Upload Thumbnail Image</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-full p-2 border border-gray-300 rounded-md">
        </div>

        <!-- Dropdown untuk Kategori -->
        <div class="mb-4">
            <label for="category" class="block text-gray-700">Select Category</label>
            <select name="category" id="category" class="w-full p-2 border border-gray-300 rounded-md" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Input untuk Published -->
        <div class="mb-4">
            <label for="is_published" class="block text-gray-700">Published</label>
            <select name="is_published" id="is_published" class="w-full p-2 border border-gray-300 rounded-md">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create Course</button>
        </div>
    </form>
</main>
@endsection

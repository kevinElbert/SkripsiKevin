@extends('main')

@section('title', 'Edit Course')

@section('content')
<main class="container mx-auto my-8 px-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Course</h2>

    <!-- Form untuk edit course -->
    <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-md shadow-md">
        @csrf
        @method('PATCH') <!-- Method PATCH untuk update data -->

        <!-- Input untuk Course Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Course Title</label>
            <input type="text" name="title" id="title" value="{{ $course->title }}" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <!-- Input untuk Course Description -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Description</label>
            <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required>{{ $course->description }}</textarea>
        </div>

        <!-- Input untuk Upload Video -->
        <div class="mb-4">
            <label for="video" class="block text-gray-700">Upload New Video</label>
            <input type="file" name="video" id="video" accept="video/*" class="w-full p-2 border border-gray-300 rounded-md">
            <small class="text-gray-600">Current Video: {{ $course->video }}</small>
        </div>

        <!-- Input untuk Upload Gambar -->
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Upload Thumbnail Image</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-full p-2 border border-gray-300 rounded-md">
            <small class="text-gray-600">Current Image: <img src="{{ $course->image }}" alt="Current Image" width="100"></small>
        </div>

        <!-- Dropdown untuk Kategori -->
        <div class="mb-4">
            <label for="category" class="block text-gray-700">Select Category</label>
            <select name="category" id="category" class="w-full p-2 border border-gray-300 rounded-md" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Input untuk Published -->
        <div class="mb-4">
            <label for="is_published" class="block text-gray-700">Published</label>
            <select name="is_published" id="is_published" class="w-full p-2 border border-gray-300 rounded-md">
                <option value="1" {{ $course->is_published ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$course->is_published ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Course</button>
        </div>
    </form>
</main>
@endsection

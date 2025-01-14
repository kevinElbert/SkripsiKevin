@extends('main')

@section('title', 'Create Course')

@section('content')
<main class="container mx-auto my-8 px-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Create New Course</h2>

    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-md shadow-md">
        @csrf

        <!-- Input untuk Course Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Course Title</label>
            <input type="text" name="title" id="title" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <!-- Input untuk Short Description -->
        <div class="mb-4">
            <label for="short_description" class="block text-gray-700">Short Description</label>
            <textarea name="short_description" id="short_description" class="w-full p-2 border border-gray-300 rounded-md" rows="3" placeholder="Provide a brief description of the course"></textarea>
        </div>

        <!-- Input untuk Learning Points -->
        <div class="mb-4">
            <label for="learning_points" class="block text-gray-700">What You Will Learn</label>
            <div id="learning-points-container">
                <div class="learning-point-item flex items-center mb-2">
                    <input type="text" name="learning_points[]" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter a learning point">
                    <button type="button" class="ml-2 bg-red-500 text-white px-4 py-1 rounded-md remove-learning-point">Delete</button>
                </div>
            </div>
            <button type="button" id="add-learning-point" class="mt-2 bg-green-500 text-white px-4 py-1 rounded-md">Add Another Point</button>
        </div>

        <!-- Input untuk Course Description -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700">Course Description</label>
            <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded-md" rows="4" required></textarea>
        </div>

        <!-- Input untuk Upload Video dan Gambar -->
        <div class="mb-4">
            <label for="video" class="block text-gray-700">Upload Course Video</label>
            <input type="file" name="video" id="video" accept="video/*" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Upload Thumbnail Image</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-full p-2 border border-gray-300 rounded-md">
        </div>

        <!-- Dropdown untuk Kategori dan Published -->
        <div class="mb-4">
            <label for="category" class="block text-gray-700">Select Category</label>
            <select name="category" id="category" class="w-full p-2 border border-gray-300 rounded-md" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="is_published" class="block text-gray-700">Published</label>
            <select name="is_published" id="is_published" class="w-full p-2 border border-gray-300 rounded-md">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <!-- Bagian untuk Input Sub-Topics -->
        <div id="subTopicsContainer">
            <h4>Sub-Topics</h4>
            <div class="sub-topic-group mb-4 flex items-start">
                <div class="w-full">
                    <label for="sub_topics[0][title]">Title:</label>
                    <input type="text" name="sub_topics[0][title]" class="w-full p-2 border border-gray-300 rounded-md" required>

                    <label for="sub_topics[0][description]">Description:</label>
                    <textarea name="sub_topics[0][description]" class="w-full p-2 border border-gray-300 rounded-md"></textarea>

                    <label for="sub_topics[0][video]">Upload Video:</label>
                    <input type="file" name="sub_topics[0][video]" accept="video/*" class="w-full p-2 border border-gray-300 rounded-md">
                </div>
                <button type="button" class="ml-4 bg-red-500 text-white px-4 py-1 rounded-md remove-sub-topic">Delete</button>
            </div>
        </div>

        <button type="button" onclick="addSubTopic()" class="mt-4 bg-green-500 text-white px-4 py-1 rounded-md">Add Another Sub-Topic</button>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create Course</button>
        </div>
    </form>
</main>

<script>
    let subTopicCount = 1;

    // Tambah Sub-Topic
    function addSubTopic() {
        const container = document.getElementById('subTopicsContainer');
        const subTopicGroup = document.createElement('div');
        subTopicGroup.classList.add('sub-topic-group', 'mb-4', 'flex', 'items-start');

        subTopicGroup.innerHTML = `
            <div class="w-full">
                <label for="sub_topics[${subTopicCount}][title]">Title:</label>
                <input type="text" name="sub_topics[${subTopicCount}][title]" class="w-full p-2 border border-gray-300 rounded-md" required>

                <label for="sub_topics[${subTopicCount}][description]">Description:</label>
                <textarea name="sub_topics[${subTopicCount}][description]" class="w-full p-2 border border-gray-300 rounded-md"></textarea>

                <label for="sub_topics[${subTopicCount}][video]">Upload Video:</label>
                <input type="file" name="sub_topics[${subTopicCount}][video]" accept="video/*" class="w-full p-2 border border-gray-300 rounded-md">
            </div>
            <button type="button" class="ml-4 bg-red-500 text-white px-4 py-1 rounded-md remove-sub-topic">Delete</button>
        `;

        container.appendChild(subTopicGroup);
        subTopicCount++;
    }

    // Hapus Learning Point
    document.getElementById('learning-points-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-learning-point')) {
            e.target.parentElement.remove();
        }
    });

    // Hapus Sub-Topic
    document.getElementById('subTopicsContainer').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-sub-topic')) {
            e.target.parentElement.remove();
        }
    });

    // Tambah Learning Point
    document.getElementById('add-learning-point').addEventListener('click', function () {
        const container = document.getElementById('learning-points-container');
        const learningPoint = document.createElement('div');
        learningPoint.classList.add('learning-point-item', 'flex', 'items-center', 'mb-2');
        learningPoint.innerHTML = `
            <input type="text" name="learning_points[]" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Enter a learning point">
            <button type="button" class="ml-2 bg-red-500 text-white px-4 py-1 rounded-md remove-learning-point">Delete</button>
        `;
        container.appendChild(learningPoint);
    });
</script>
@endsection

@extends('main')

@section('title', 'Edit Course')

@section('content')
<main class="container mx-auto my-8 px-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Edit Course</h2>

    <!-- Form untuk edit course -->
    <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-md shadow-md">
        @csrf
        @method('PATCH')

        <!-- Input untuk Course Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Course Title</label>
            <input type="text" name="title" id="title" value="{{ $course->title }}" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <!-- Input untuk Short Description -->
        <div class="mb-4">
            <label for="short_description" class="block text-gray-700">Short Description</label>
            <textarea name="short_description" id="short_description" class="w-full p-2 border border-gray-300 rounded-md" rows="3">{{ $course->short_description }}</textarea>
        </div>

        <!-- Input untuk Learning Points -->
        <div class="mb-4">
            <label for="learning_points" class="block text-gray-700">What You Will Learn</label>
            <div id="learning-points-container">
                @if($course->learning_points)
                    @foreach($course->learning_points as $point)
                        <input type="text" name="learning_points[]" value="{{ $point }}" class="w-full p-2 border border-gray-300 rounded-md mb-2" placeholder="Enter a learning point">
                    @endforeach
                @else
                    <input type="text" name="learning_points[]" class="w-full p-2 border border-gray-300 rounded-md mb-2" placeholder="Enter a learning point">
                @endif
            </div>
            <button type="button" id="add-learning-point" class="mt-2 bg-green-500 text-white px-4 py-1 rounded-md">Add Another Point</button>
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

        <!-- Sub-Topics Section -->
        <div id="subTopicsContainer" class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Sub-Topics</h3>
            @foreach($course->subTopics as $index => $subTopic)
                <div class="sub-topic-group mb-4 border p-4 rounded-md">
                    <label for="sub_topics[{{ $index }}][title]" class="block text-gray-700">Title:</label>
                    <input type="text" name="sub_topics[{{ $index }}][title]" value="{{ $subTopic->title }}" class="w-full p-2 border border-gray-300 rounded-md mb-2" required>

                    <label for="sub_topics[{{ $index }}][description]" class="block text-gray-700">Description:</label>
                    <textarea name="sub_topics[{{ $index }}][description]" class="w-full p-2 border border-gray-300 rounded-md mb-2">{{ $subTopic->description }}</textarea>

                    <label for="sub_topics[{{ $index }}][video]" class="block text-gray-700">Upload Video:</label>
                    <input type="file" name="sub_topics[{{ $index }}][video]" accept="video/*" class="w-full p-2 border border-gray-300 rounded-md">
                    <small class="text-gray-600">Current Video: {{ $subTopic->video }}</small>

                    <!-- Delete Sub-Topic -->
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md mt-4" onclick="deleteSubTopic(this)">Delete Sub-Topic</button>
                </div>
            @endforeach
        </div>

        <button type="button" class="bg-green-500 text-white px-4 py-2 rounded-md mb-4" onclick="addSubTopic()">Add Another Sub-Topic</button>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Course</button>
        </div>
    </form>
</main>

<script>
    function addSubTopic() {
        const container = document.getElementById('subTopicsContainer');
        const subTopicCount = container.querySelectorAll('.sub-topic-group').length;
        const subTopicGroup = document.createElement('div');
        subTopicGroup.classList.add('sub-topic-group', 'mb-4', 'border', 'p-4', 'rounded-md');

        subTopicGroup.innerHTML = `
            <label for="sub_topics[${subTopicCount}][title]" class="block text-gray-700">Title:</label>
            <input type="text" name="sub_topics[${subTopicCount}][title]" class="w-full p-2 border border-gray-300 rounded-md mb-2" required>

            <label for="sub_topics[${subTopicCount}][description]" class="block text-gray-700">Description:</label>
            <textarea name="sub_topics[${subTopicCount}][description]" class="w-full p-2 border border-gray-300 rounded-md mb-2"></textarea>

            <label for="sub_topics[${subTopicCount}][video]" class="block text-gray-700">Upload Video:</label>
            <input type="file" name="sub_topics[${subTopicCount}][video]" accept="video/*" class="w-full p-2 border border-gray-300 rounded-md">

            <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-md mt-4" onclick="deleteSubTopic(this)">Delete Sub-Topic</button>
        `;

        container.appendChild(subTopicGroup);
    }

    function deleteSubTopic(button) {
        button.closest('.sub-topic-group').remove();
    }
</script>
@endsection

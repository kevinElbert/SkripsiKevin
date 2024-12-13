@if (isset($courses) && $courses->isNotEmpty())
    <div id="create-thread-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center">
        <div class="bg-white w-1/2 p-6 rounded shadow-md">
            <h2 class="text-xl font-semibold mb-4">Create New Thread</h2>
            <form action="{{ route('forum.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="course_id" class="block text-gray-700">Course</label>
                    <select name="course_id" id="course_id" class="w-full p-2 border border-gray-300 rounded" required>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Title</label>
                    <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-gray-700">Content</label>
                    <textarea id="content" name="content" rows="4" class="w-full p-2 border border-gray-300 rounded" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2" data-close-modal>Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
                </div>
            </form>
        </div>
    </div>
@endif

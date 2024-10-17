@extends('main')

@section('title', 'Manage Courses')

@section('content')
<main class="container mx-auto my-8 px-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Manage Courses</h2>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Title</th>
                <th class="py-2">Category</th>
                <th class="py-2">Status</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td class="py-2">{{ $course->title }}</td>
                    <td class="py-2">{{ $course->category->name }}</td>
                    <td class="py-2">{{ $course->is_published ? 'Published' : 'Unpublished' }}</td>
                    <td class="py-2">
                        <a href="{{ route('courses.edit', $course->id) }}" class="bg-yellow-500 text-white px-2 py-1">Edit</a>
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('courses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">Create New Course</a>
</main>
@endsection

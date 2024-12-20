@extends('main')

@section('title', 'Manage Quizzes')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Quiz Management</h1>

    <!-- Tombol untuk menambah quiz -->
    @foreach ($courses as $course)
        <a href="{{ route('quizzes.create', ['courseId' => $course->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
            Create New Quiz for {{ $course->title }}
        </a>
    @endforeach

    <!-- Daftar Quiz -->
    <table class="table-auto w-full border-collapse border">
        <thead>
            <tr>
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2">Title</th>
                <th class="border px-4 py-2">Course</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($quizzes as $quiz)
                <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $quiz->title }}</td>
                    <td class="border px-4 py-2">{{ $quiz->course->title }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="text-blue-500">View</a>
                        <a href="{{ route('quizzes.edit', $quiz->id) }}" class="text-yellow-500 ml-2">Edit</a>
                        <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="border px-4 py-2 text-center">No quizzes found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

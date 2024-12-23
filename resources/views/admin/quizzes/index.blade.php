@extends('main')

@section('title', 'Manage Quizzes')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Quiz Management</h1>

    <!-- Statistik -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-6 shadow-md rounded-md text-center border border-gray-200">
            <h3 class="text-xl font-bold mb-2">Total Quizzes</h3>
            <p class="text-2xl">{{ $totalQuizzes }}</p>
        </div>

        <div class="bg-white p-6 shadow-md rounded-md text-center border border-gray-200">
            <h3 class="text-xl font-bold mb-2">Total Questions</h3>
            <p class="text-2xl">{{ $totalQuestions }}</p>
        </div>

        <div class="bg-white p-6 shadow-md rounded-md text-center border border-gray-200">
            <h3 class="text-xl font-bold mb-2">Most Active Course</h3>
            <p class="text-2xl">{{ $mostActiveCourse->title ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Sorting -->
    <div class="mb-4">
        <a href="{{ route('quizzes.index', ['sort' => 'title']) }}" class="text-blue-500">Sort by Title</a>
    </div>

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

    <!-- Pagination -->
    <div class="mt-6">
        {{ $quizzes->links() }}
    </div>
</div>
@endsection

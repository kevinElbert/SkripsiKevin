@extends('main')

@section('title', 'Manage Quizzes')

@section('content')
<div class="container mx-auto my-8 px-4">
    <h1 class="text-2xl font-bold mb-4">Quiz Management</h1>

    <!-- Statistik -->
    <div class="grid grid-cols-4 gap-4 mb-6">
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

        <div class="bg-white p-6 shadow-md rounded-md text-center border border-gray-200">
            <h3 class="text-xl font-bold mb-2">Total Attempts</h3>
            <p class="text-2xl">{{ $totalAttempts }}</p>
        </div>
    </div>

    <div class="flex gap-4 mb-4">
        <select id="statusFilter" class="border rounded px-3 py-1">
            <option value="">All Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
    
        <select id="sortBy" class="border rounded px-3 py-1">
            <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Sort by Title</option>
            <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Sort by Date</option>
        </select>
    </div>
    
    @push('scripts')
    <script>
        document.getElementById('statusFilter').addEventListener('change', function() {
            window.location.href = '{{ route('quizzes.index') }}?status=' + this.value + '&sort=' + document.getElementById('sortBy').value;
        });
    
        document.getElementById('sortBy').addEventListener('change', function() {
            window.location.href = '{{ route('quizzes.index') }}?status=' + document.getElementById('statusFilter').value + '&sort=' + this.value;
        });
    </script>
    @endpush

    <!-- Daftar Quiz -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Passing Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempts</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($quizzes as $quiz)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $quiz->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $quiz->course->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $quiz->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $quiz->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $quiz->passing_score }}%</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $quiz->results()->count() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="{{ route('quizzes.show', $quiz->id) }}" 
                                   class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('quizzes.edit', $quiz->id) }}" 
                                   class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Are you sure you want to delete this quiz?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center">No quizzes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $quizzes->links() }}
    </div>
</div>
@endsection
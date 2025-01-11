@extends('main')

@section('title', 'Quiz History')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Your Quiz History</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-6 bg-gray-50">
            <div class="text-center">
                <p class="text-gray-600">Total Quizzes Taken</p>
                <p class="text-2xl font-bold">{{ $quizAttempts->count() }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-600">Average Score</p>
                <p class="text-2xl font-bold">{{ number_format($averageScore, 1) }}%</p>
            </div>
            <div class="text-center">
                <p class="text-gray-600">Passing Rate</p>
                <p class="text-2xl font-bold">{{ number_format($passingRate, 1) }}%</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($quizAttempts as $attempt)
                    <tr>
                        <td class="px-6 py-4">{{ $attempt->quiz->title }}</td>
                        <td class="px-6 py-4">{{ $attempt->quiz->course->title }}</td>
                        <td class="px-6 py-4">{{ $attempt->score }}%</td>
                        <td class="px-6 py-4">
                            @if($attempt->hasPassed())
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Passed
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $attempt->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('user.quiz.review', $attempt->id) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                Review
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            You haven't taken any quizzes yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
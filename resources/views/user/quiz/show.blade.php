@extends('main')

@section('title', 'Take Quiz')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-2">{{ $quiz->title }}</h1>
        <div class="bg-white rounded-lg shadow p-6 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-600">Time Limit</p>
                    <p class="text-xl font-bold">{{ $quiz->time_limit ?? 'No limit' }} minutes</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-600">Passing Score</p>
                    <p class="text-xl font-bold">{{ $quiz->passing_score }}%</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-600">Attempts Left</p>
                    <p class="text-xl font-bold">{{ $quiz->attempts_allowed - $attemptCount }}</p>
                </div>
            </div>

            @if($canTakeQuiz)
                <form action="{{ route('user.quiz.start', $quiz->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                        Start Quiz
                    </button>
                </form>
            @else
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <p class="text-yellow-700">You have reached the maximum number of attempts for this quiz.</p>
                    <p class="font-bold">Your highest score: {{ $highestScore }}%</p>
                </div>
            @endif
        </div>

        @if($previousAttempts->count() > 0)
            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">Previous Attempts</h2>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempt</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($previousAttempts as $attempt)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->score }}%</td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                <td class="px-6 py-4 whitespace-nowrap">{{ $attempt->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
@extends('main')

@section('title', 'Quiz Details')

@section('content')
<div class="container mx-auto my-8 px-4">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">Quiz Details</h1>
                <div class="flex gap-2">
                    <a href="{{ route('quizzes.edit', $quiz->id) }}" 
                       class="bg-yellow-500 text-white px-4 py-2 rounded-md">Edit Quiz</a>
                </div>
            </div>

            <!-- Quiz Information -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <h2 class="font-bold text-lg mb-2">Basic Information</h2>
                    <div class="space-y-2">
                        <p><span class="font-semibold">Title:</span> {{ $quiz->title }}</p>
                        <p><span class="font-semibold">Course:</span> {{ $quiz->course->title }}</p>
                        <p><span class="font-semibold">Status:</span> 
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $quiz->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $quiz->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div>
                    <h2 class="font-bold text-lg mb-2">Quiz Settings</h2>
                    <div class="space-y-2">
                        <p><span class="font-semibold">Passing Score:</span> {{ $quiz->passing_score }}%</p>
                        <p><span class="font-semibold">Time Limit:</span> 
                            {{ $quiz->time_limit ? $quiz->time_limit.' minutes' : 'No limit' }}
                        </p>
                        <p><span class="font-semibold">Attempts Allowed:</span> 
                            {{ $quiz->attempts_allowed ? $quiz->attempts_allowed : 'Unlimited' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Quiz Statistics -->
            <div class="mb-6">
                <h2 class="font-bold text-lg mb-2">Statistics</h2>
                <div class="grid grid-cols-4 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-sm text-blue-700">Total Attempts</h3>
                        <p class="text-2xl font-bold text-blue-900">{{ $quiz->results()->count() }}</p>
                    </div>
                    
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-sm text-green-700">Average Score</h3>
                        <p class="text-2xl font-bold text-green-900">
                            {{ number_format($quiz->results()->avg('score'), 1) }}%
                        </p>
                    </div>
                    
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-sm text-yellow-700">Pass Rate</h3>
                        <p class="text-2xl font-bold text-yellow-900">
                            {{ number_format($quiz->results()->where('passed', true)->count() / max(1, $quiz->results()->count()) * 100, 1) }}%
                        </p>
                    </div>

                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-sm text-purple-700">Total Questions</h3>
                        <p class="text-2xl font-bold text-purple-900">{{ count($quiz->questions) }}</p>
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div>
                <h2 class="font-bold text-lg mb-4">Questions</h2>
                <div class="space-y-4">
                    @foreach($quiz->questions as $index => $question)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <p class="font-bold">Question {{ $index + 1 }}</p>
                                @if(isset($question['media']))
                                    <div class="text-sm text-gray-500">Has Media</div>
                                @endif
                            </div>
                            <p class="mt-2">{{ $question['question'] }}</p>
                            
                            <!-- Options -->
                            <div class="mt-3 space-y-2">
                                <p class="font-semibold">Options:</p>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($question['options'] as $optionIndex => $option)
                                        <div class="p-2 rounded {{ $option === $question['correct_answer'] ? 'bg-green-100' : 'bg-gray-100' }}">
                                            {{ chr(65 + $optionIndex) }}. {{ $option }}
                                            @if($option === $question['correct_answer'])
                                                <span class="text-green-600 text-sm ml-2">(Correct)</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Attempts -->
            @if($quiz->results()->count() > 0)
                <div class="mt-6">
                    <h2 class="font-bold text-lg mb-4">Recent Attempts</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($quiz->results()->with('user')->latest()->take(5)->get() as $result)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $result->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $result->score }}%</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $result->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $result->passed ? 'Passed' : 'Failed' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $result->created_at->format('M d, Y H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
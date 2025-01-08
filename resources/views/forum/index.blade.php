@extends('main')

@section('title', 'Forum Threads')

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-2xl font-bold mb-6">Forum Threads</h1>

    <!-- Daftar Threads -->
    <div class="mt-8">
        @foreach ($threads as $thread)
            <div class="bg-white p-4 rounded shadow mb-4 category-container">
                <h2 class="text-xl font-semibold">
                    <a href="{{ route('forum.show', $thread->id) }}" class="text-blue-500 hover:underline">
                        {{ $thread->title }}
                    </a>
                </h2>
                <p class="text-gray-700">{{ Str::limit($thread->content, 100) }}</p>
                <p class="text-sm text-gray-500">By: {{ $thread->user->name }} | {{ $thread->created_at->diffForHumans() }}</p>
            </div>
        @endforeach

        <!-- Pagination -->
        @if($threads->hasPages())
            <div class="mt-4">
                {{ $threads->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

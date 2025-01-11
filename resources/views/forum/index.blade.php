@extends('main')

@section('title', 'Forum Threads')

@section('content')
<div class="container mx-auto my-8" data-course-id="{{ $course->id }}">
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

                <!-- Tombol Delete Thread untuk Admin -->
                @if (Auth::user()->is_admin || $thread->user_id == Auth::id())
                    <form action="{{ route('forum.thread.delete', $thread->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this thread?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Delete Thread</button>
                    </form>
                @endif
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

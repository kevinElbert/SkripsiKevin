@extends('main')

@section('title', $thread->title)

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-2xl font-bold mb-4">{{ $thread->title }}</h1>
    <p class="text-gray-700 mb-4">{{ $thread->content }}</p>
    <p class="text-sm text-gray-500 mb-6">By: {{ $thread->user->name }} | {{ $thread->created_at->format('d M Y, H:i') }}</p>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form untuk Komentar -->
    <form action="{{ route('forum.comment.store', $thread->id) }}" method="POST" class="mb-6">
        @csrf
        <textarea name="content" rows="3" class="w-full p-2 border border-gray-300 rounded mb-2" placeholder="Add a comment..." required></textarea>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Post Comment</button>
    </form>

    <!-- Daftar Komentar -->
    <h2 class="text-lg font-semibold mb-4">Comments</h2>
    @forelse ($thread->comments as $comment)
        <div class="bg-gray-100 p-4 rounded mb-4">
            <p class="text-gray-700">{{ $comment->content }}</p>
            <p class="text-sm text-gray-500">By: {{ $comment->user->name }} | {{ $comment->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <p class="text-gray-700">No comments yet. Be the first to comment!</p>
    @endforelse
</div>
@endsection

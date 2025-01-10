@extends('main')

@section('title', 'Thread: ' . $thread->title)

@section('content')
<div class="container mx-auto my-8 category-container">
    <h1 class="text-2xl font-bold mb-6">{{ $thread->title }}</h1>
    <p class="text-gray-700">{{ $thread->content }}</p>
    <p class="text-sm text-gray-500 mb-6">By: {{ $thread->user->name }} | {{ $thread->created_at->diffForHumans() }}</p>

    <!-- Tombol Delete Thread untuk Admin -->
    @if (Auth::user()->is_admin)
        <form action="{{ route('forum.thread.delete', $thread->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this thread?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:underline">Delete Thread</button>
        </form>
    @endif

    <!-- Comments Section -->
    <h2 class="text-xl font-semibold mb-4">Comments</h2>
    @foreach ($thread->comments as $comment)
        <div class="border-b pb-2 mb-2 category-container">
            <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
            <div class="flex space-x-2">
                <button data-open-reply-modal data-comment-id="{{ $comment->id }}" class="text-blue-500 hover:underline">Reply</button>

                <!-- Tombol Delete Comment untuk Admin -->
                @if (Auth::user()->is_admin || $comment->user_id == Auth::id())
                    <form action="{{ route('forum.comment.delete', $comment->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                    </form>
                @endif
            </div>

            <!-- Recursive Replies -->
            @if ($comment->replies->isNotEmpty())
                <div class="ml-4 border-l pl-4 mt-2 category-container">
                    @foreach ($comment->replies as $reply)
                        @include('forum.comment', ['comment' => $reply])
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach

    <!-- Add Comment -->
    <form action="{{ route('forum.comment.store', $thread->id) }}" method="POST" class="mt-4">
        @csrf
        <textarea name="content" rows="4" class="w-full p-2 border border-gray-300 rounded" placeholder="Write your comment here..." required></textarea>
        <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add Comment</button>
    </form>
</div>

<!-- Reply Modal -->
<div id="reply-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-md">
        <form action="{{ route('forum.comment.store', $thread->id) }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" id="parent-id">
            <textarea name="content" class="w-full border border-gray-300 p-2 rounded" rows="3" required></textarea>
            <div class="flex justify-end mt-2">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2" data-close-modal>Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Reply</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const replyButtons = document.querySelectorAll('[data-open-reply-modal]');
        const replyModal = document.getElementById('reply-modal');
        const parentIdInput = document.getElementById('parent-id');
        const closeModalButtons = document.querySelectorAll('[data-close-modal]');

        replyButtons.forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.getAttribute('data-comment-id');
                parentIdInput.value = commentId; // Set parent_id to the comment being replied to
                replyModal.classList.remove('hidden');
            });
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', function () {
                replyModal.classList.add('hidden');
                parentIdInput.value = ''; // Clear parent_id
            });
        });
    });
</script>
@endsection

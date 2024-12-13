<div class="border-b pb-2 mb-2">
    <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
    <div class="flex space-x-2">
        <button data-open-reply-modal data-comment-id="{{ $comment->id }}" class="text-blue-500 hover:underline">Reply</button>

        @if ($comment->user_id == auth()->id())
            <form action="{{ route('forum.comment.delete', $comment->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline">Delete</button>
            </form>
        @endif
    </div>

    <!-- Recursive Replies -->
    @if ($comment->replies->isNotEmpty())
        <div class="ml-4 border-l pl-4 mt-2">
            @foreach ($comment->replies as $reply)
                @include('forum.comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>

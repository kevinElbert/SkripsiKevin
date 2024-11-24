@extends('main')

@section('title', $thread->title)

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-3xl font-bold mb-6">{{ $thread->title }}</h1>

    <!-- Thread Content -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <p class="text-gray-700">{{ $thread->content }}</p>
        <p class="text-gray-600 text-sm mt-4">
            By {{ $thread->user->name }} | {{ $thread->created_at->diffForHumans() }}
        </p>
    </div>

    <!-- Comments Section -->
    <h2 class="text-2xl font-bold mb-4">Comments</h2>
    @if($thread->comments->isEmpty())
        <p class="text-gray-700">No comments yet. Be the first to comment!</p>
    @else
        <ul>
            @foreach($thread->comments as $comment)
                <li class="border-b py-4">
                    <p class="text-gray-700">{{ $comment->content }}</p>
                    <p class="text-gray-600 text-sm mt-2">
                        By {{ $comment->user->name }} | {{ $comment->created_at->diffForHumans() }}
                    </p>

                    @if(Auth::id() == $comment->user_id)
                        <form action="{{ route('forum.deleteComment', $comment->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm hover:underline">
                                Delete
                            </button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Add Comment -->
    <div class="mt-6">
        <h3 class="text-xl font-bold mb-4">Add Comment</h3>
        <form action="{{ route('forum.storeComment', $thread->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <textarea name="content" class="w-full p-2 border rounded" rows="4" placeholder="Write your comment here..." required></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
        </form>
    </div>
</div>
@endsection

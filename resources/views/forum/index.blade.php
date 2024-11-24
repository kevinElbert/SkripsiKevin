@extends('main')

@section('title', 'Forum Threads')

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-2xl font-bold mb-6">Forum Threads</h1>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Button untuk membuka modal -->
    <button data-open-modal class="bg-blue-500 text-white px-4 py-2 rounded-md">Create New Thread</button>

    <!-- Daftar Threads -->
    <div class="mt-8">
        @forelse ($threads as $thread)
            <div class="bg-white p-4 rounded shadow mb-4">
                <h2 class="text-xl font-semibold">{{ $thread->title }}</h2>
                <p class="text-gray-700">{{ $thread->content }}</p>
                <p class="text-sm text-gray-500">By: {{ $thread->user->name }} | {{ $thread->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="text-gray-700">No threads available. Be the first to create one!</p>
        @endforelse

        <!-- Pagination -->
        @if($threads->hasPages())
            <div class="mt-4">
                {{ $threads->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div id="create-thread-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center">
    <div class="bg-white w-1/2 p-6 rounded shadow-md">
        <h2 class="text-xl font-semibold mb-4">Create New Thread</h2>
        <form action="{{ route('forum.storeThread') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" id="title" name="title" class="w-full p-2 border border-gray-300 rounded" required>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-700">Content</label>
                <textarea id="content" name="content" rows="4" class="w-full p-2 border border-gray-300 rounded" required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="button" data-close-modal class="bg-gray-500 text-white px-4 py-2 rounded-md mr-2">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection

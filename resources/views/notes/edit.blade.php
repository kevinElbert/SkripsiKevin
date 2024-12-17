@extends('main')

@section('title', 'Edit Note')

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-2xl font-bold mb-4">Edit Note</h1>

    <form action="{{ route('notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium">Title</label>
            <input id="title" name="title" type="text" value="{{ old('title', $note->title) }}"
                   class="w-full p-2 border border-gray-300 rounded">
        </div>     

        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-medium">Content</label>
            <textarea id="content" name="content" rows="5" 
                      class="w-full p-2 border border-gray-300 rounded">{{ old('content', $note->content) }}</textarea>
        </div>

        <div class="flex items-center space-x-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Note</button>
            <a href="{{ route('notes.index') }}" class="text-gray-700 hover:underline">Cancel</a>
        </div>
    </form>
</div>
@endsection

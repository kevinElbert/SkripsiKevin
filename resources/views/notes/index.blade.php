@extends('main')

@section('title', 'My Notes')

@section('content')
@vite('resources/css/app.css')
<div class="container mx-auto my-8">
    <h1 class="text-2xl font-bold mb-6">My Notes</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($notes as $note)
        <div onclick="window.location='{{ route('notes.show', $note->id) }}'"
            class="bg-white p-4 rounded shadow hover:shadow-lg transition cursor-pointer">
           <h2 class="font-semibold text-lg mb-2">{{ $note->title }}</h2> <!-- Tampilkan Title -->
           <p class="text-sm text-gray-500 mb-1">
               Sub-topic: {{ $note->subTopic->title ?? 'N/A' }}
           </p>
           <p class="text-gray-700 mb-4">
               {{ Str::limit($note->content, 100, '...') }}
           </p>
           <div class="flex justify-between items-center">
               <a href="{{ route('notes.edit', $note->id) }}" class="text-blue-500 hover:underline">Edit</a>
               <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                   @csrf
                   @method('DELETE')
                   <button type="submit" class="text-red-500 hover:underline">Delete</button>
               </form>
           </div>
       </div>              
        @empty
            <p class="text-gray-700 col-span-3">You have no notes yet.</p>
        @endforelse
    </div>
</div>
@endsection

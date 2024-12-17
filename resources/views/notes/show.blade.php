@extends('main')

@section('title', 'View Note')

@section('content')
<div class="container mx-auto my-8">
    <h1 class="text-2xl font-bold mb-4">Note Details</h1>
    <div class="bg-white p-6 rounded shadow">
        <h2 class="mb-2 font-semibold text-xl">Title: {{ $note->title }}</h2> <!-- Tambahkan Title -->
        <h2 class="mb-2 font-semibold text-xl">Course: {{ $note->course->title }}</h2>
        <p class="font-semibold text-xl mb-4">Sub-Topic: {{ $note->subTopic->title ?? 'N/A' }}</p>
        <p class="text-gray-700">{{ $note->content }}</p>
        <p class="text-sm text-gray-500 mt-4">
            Created At: {{ $note->created_at->format('d M Y, H:i') }}
        </p>
        <a href="{{ route('notes.index') }}" class="text-blue-500 hover:underline mt-4 inline-block">
            Back to Notes
        </a>
    </div>
</div>
@endsection

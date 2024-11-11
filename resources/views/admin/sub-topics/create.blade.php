<!-- resources/views/admin/sub_topics/create.blade.php -->
@extends('main')

@section('content')
    <h2>Create Sub-Topic for {{ $course->title }}</h2>
    <form action="{{ route('admin.sub_topics.store', $course->id) }}" method="POST">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <br>
 
        <label for="description">Description:</label>
        <textarea name="description"></textarea>
        <br>

        <label for="video_url">Video URL:</label>
        <input type="url" name="video_url">
        <br>

        <button type="submit">Save Sub-Topic</button>
    </form>
@endsection

@extends('main')

@section('content')
    <h2>Create Sub-Topic for {{ $course->title }}</h2>
    <form action="{{ route('admin.sub_topics.store', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" required>
        <br>

        <label for="description">Description:</label>
        <textarea name="description"></textarea>
        <br>

        <label for="video">Upload Video:</label>
        <input type="file" name="video" accept="video/*">
        <br>

        <button type="submit">Save Sub-Topic</button>
    </form>
@endsection

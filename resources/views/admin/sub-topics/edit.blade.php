@extends('main')

@section('content')
    <h2>Edit Sub-Topic: {{ $subTopic->title }}</h2>
    <form action="{{ route('admin.sub_topics.update', [$subTopic->course_id, $subTopic->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <label for="title">Title:</label>
        <input type="text" name="title" value="{{ old('title', $subTopic->title) }}" required>
        <br>

        <label for="description">Description:</label>
        <textarea name="description">{{ old('description', $subTopic->description) }}</textarea>
        <br>

        <label for="video">Upload Video:</label>
        <input type="file" name="video" accept="video/*">
        <br>
        @if($subTopic->video_url)
            <p>Current Video: <a href="{{ $subTopic->video_url }}" target="_blank">View Video</a></p>
        @endif

        <button type="submit">Update Sub-Topic</button>
    </form>
@endsection

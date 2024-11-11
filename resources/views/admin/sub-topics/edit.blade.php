@extends('admin.layouts.app')

@section('content')
    <h2>Edit Course: {{ $course->title }}</h2>
    
    <!-- Form untuk Edit Kursus -->
    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <label for="title">Title:</label>
        <input type="text" name="title" value="{{ $course->title }}" required>
        <br>

        <label for="description">Description:</label>
        <textarea name="description">{{ $course->description }}</textarea>
        <br>

        <button type="submit">Update Course</button>
    </form>

    <hr>

    <!-- Bagian untuk Mengelola Sub-Topics -->
    <h3>Manage Sub-Topics</h3>
    <a href="{{ route('admin.sub_topics.create', $course->id) }}" class="btn btn-primary">Create Sub-Topic</a>

    <ul>
        @foreach($course->subTopics as $subTopic)
            <li>
                {{ $subTopic->title }}
                <a href="{{ route('admin.sub_topics.edit', [$course->id, $subTopic->id]) }}">Edit</a>
                <form action="{{ route('admin.sub_topics.destroy', [$course->id, $subTopic->id]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection

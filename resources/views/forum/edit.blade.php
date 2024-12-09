@extends('layouts.app')

@section('content')
    <h1>Edit Thread</h1>

    <form action="{{ route('forum.updateThread', $thread->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $thread->title) }}" required>
        </div>

        <div>
            <label for="content">Content</label>
            <textarea name="content" id="content" required>{{ old('content', $thread->content) }}</textarea>
        </div>

        <div>
            <button type="submit">Update Thread</button>
        </div>
    </form>
@endsection

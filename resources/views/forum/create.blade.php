@extends('layouts.app')

@section('content')
    <h1>Create a new thread</h1>

    <form action="{{ route('forum.storeThread') }}" method="POST">
        @csrf
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" required>
        </div>

        <div>
            <label for="content">Content</label>
            <textarea name="content" id="content" required></textarea>
        </div>

        <div>
            <button type="submit">Create Thread</button>
        </div>
    </form>
@endsection

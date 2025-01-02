<!-- resources/views/admin/sub_topics/index.blade.php -->
@extends('main')

@section('content')
    <h2>Sub-Topics for {{ $course->title }}</h2>
    <a href="{{ route('admin.sub_topics.create', $course->id) }}">Add New Sub-Topic</a>
    <ul>
        @foreach($course->subTopics as $subTopic)
            <li>
                <strong>{{ $subTopic->title }}</strong> <br>
                Description: {{ $subTopic->description ?? 'No description' }} <br>
                Video: 
                @if($subTopic->video_url)
                    <a href="{{ $subTopic->video_url }}" target="_blank">View Video</a>
                @else
                    No Video URL
                @endif
                <br>
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

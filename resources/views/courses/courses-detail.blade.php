@extends('main')

@section('title', $course->title)

@vite('resources/js/tts.js')

@section('content')
<div class="container mx-auto my-8 px-4 grid grid-cols-4 gap-6" data-course-id="{{ $course->id }}">
    <!-- Sub-Topic List (Kiri) -->
    <div class="col-span-1 bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Course List</h2>
            <ul class="space-y-2">
                @foreach($subTopics as $subTopic)
                    <li>
                        <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $subTopic->id]) }}"
                           class="block p-3 rounded-lg transition-all {{ request('subTopic') == $subTopic->id ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                            {{ $subTopic->title }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="mt-6">
                <a href="{{ route('user.quiz.show', $course->id) }}" 
                   class="block w-full text-center bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Take Quiz
                </a>
            </div>

            <div class="px-6 py-4 bg-gray-100 border-t border-gray-200">
                <a href="{{ route('courses.show', $course->slug) }}" 
                   class="block w-full text-center bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors">
                    Back to Main Course
                </a>
            </div>
        </div>
    </div>

    <!-- Video and Navigation (Tengah) -->
    <div class="col-span-2 bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">{{ $currentSubTopic->title ?? $course->title }}</h2>
        </div>

        <!-- Video Container -->
        <div class="relative bg-black">
            @if($previousSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id]) }}"
                   class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 rounded-full p-3 transition-all z-10">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
            @endif

            <video id="video-player" class="w-full aspect-video" controls>
                <source src="{{ $currentSubTopic->video ?? $course->video }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            @if($nextSubTopic)
                <a href="{{ route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id]) }}"
                   class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 rounded-full p-3 transition-all z-10">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @endif
        </div>

        <!-- Controls Container -->
        <div class="px-6 py-4 bg-gray-50 border-t border-b border-gray-200">
            <div class="flex items-center justify-between">
                <!-- Navigation Links -->
                <div class="flex items-center space-x-4">
                    <a href="{{ $previousSubTopic ? route('courses.show', ['slug' => $course->slug, 'subTopic' => $previousSubTopic->id]) : '#' }}"
                       class="{{ $previousSubTopic ? 'text-blue-600 hover:text-blue-700' : 'text-gray-400 cursor-not-allowed' }} font-medium">
                       <span class="flex items-center">
                           <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                           </svg>
                           Previous
                       </span>
                    </a>
                    <a href="{{ route('forum.index', ['course_id' => $course->id]) }}" 
                       class="text-blue-600 hover:text-blue-700 font-medium">
                       Forum Discussion
                    </a>
                    <a href="{{ $nextSubTopic ? route('courses.show', ['slug' => $course->slug, 'subTopic' => $nextSubTopic->id]) : '#' }}"
                       class="{{ $nextSubTopic ? 'text-blue-600 hover:text-blue-700' : 'text-gray-400 cursor-not-allowed' }} font-medium">
                       <span class="flex items-center">
                           Next
                           <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                           </svg>
                       </span>
                    </a>
                </div>

                <!-- Download Button -->
                <button 
                    id="downloadBtn"
                    onclick="downloadVideo('{{ $course->id }}')"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none transition-colors shadow-sm"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Video
                </button>
            </div>
        </div>

        <!-- Notes Form -->
        <div class="p-6">
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Add Notes</h3>
                <form action="{{ route('notes.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="sub_topic_id" value="{{ $currentSubTopic->id ?? '' }}">
            
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input id="title" name="title" type="text" 
                               class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               placeholder="Enter note title...">
                    </div>
            
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                        <textarea name="content" id="content" rows="3" 
                              class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Write your notes here..."></textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none transition-colors">
                            Save Note
                        </button>
                        <a href="{{ route('notes.index') }}" 
                           class="text-blue-600 hover:text-blue-700 font-medium">
                            View All Notes
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Description (Kanan) -->
    <div class="col-span-1 bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <span>About This Course</span>
            </h2>
        </div>
        <div class="p-6 about-course-content">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">
                What is {{ $currentSubTopic->title ?? $course->title }}?
            </h3>
            <p id="description-text" class="text-gray-600 leading-relaxed">
                {{ $currentSubTopic->description ?? $course->description }}
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoPlayer = document.getElementById('video-player');
    const courseId = {{ $course->id }};
    const userId = {{ Auth::id() }};

    videoPlayer.addEventListener('timeupdate', function() {
        const currentTime = videoPlayer.currentTime;
        const halfDuration = videoPlayer.duration * 0.5;

        if (currentTime >= halfDuration) {
            updateProgress(courseId, userId, 50);
            videoPlayer.removeEventListener('timeupdate', arguments.callee);
        }
    });

    function updateProgress(courseId, userId, progress) {
        axios.post(`/courses/${courseId}/progress`, {
            user_id: userId,
            progress: progress
        })
        .then(response => {
            console.log('Progress updated successfully');
        })
        .catch(error => {
            console.error('Error updating progress:', error);
        });
    }
});

function downloadVideo(courseId) {
    const downloadBtn = document.getElementById('downloadBtn');
    const originalText = downloadBtn.innerHTML;
    downloadBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Downloading...
    `;
    downloadBtn.disabled = true;

    fetch(`/courses/${courseId}/download-video`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.error || 'Failed to download video');
            });
        }
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = `course-video.mp4`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    })
    .catch(error => {
        alert(error.message || 'Failed to download video.');
    })
    .finally(() => {
        downloadBtn.innerHTML = originalText;
        downloadBtn.disabled = false;
    });
}
</script>
@endsection
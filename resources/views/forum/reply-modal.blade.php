<div id="reply-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow-md">
        <form action="{{ route('forum.comment.store', $thread->id) }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" id="parent-id">
            <textarea name="content" class="w-full border border-gray-300 p-2 rounded" rows="3" required></textarea>
            <div class="flex justify-end mt-2">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded mr-2" data-close-modal>Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Reply</button>
            </div>
        </form>
    </div>
</div>

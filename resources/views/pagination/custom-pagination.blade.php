@if ($paginator->hasPages())
    <nav>
        <ul class="flex justify-center space-x-4">
            {{-- Hapus tombol "Previous" --}}
            {{-- @if ($paginator->onFirstPage())
                <li class="text-gray-500 px-4 py-2 bg-gray-200 rounded-md cursor-not-allowed">
                    Previous
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Previous
                    </a>
                </li>
            @endif --}}

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Show More
                    </a>
                </li>
            @else
                <li class="text-gray-500 px-4 py-2 bg-gray-200 rounded-md cursor-not-allowed">
                    Show More
                </li>
            @endif
        </ul>
    </nav>
@endif

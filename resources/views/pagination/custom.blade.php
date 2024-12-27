{{-- @if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center space-x-4 mt-4"> --}}
        {{-- Tombol Previous --}}
        {{-- @if ($paginator->onFirstPage())
            <span class="px-4 py-2 bg-gray-300 text-gray-600 rounded-md cursor-not-allowed">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600" 
               data-container-id="{{ $containerId ?? '' }}">
                Previous
            </a>
        @endif --}}

        {{-- Tombol Next --}}
        {{-- @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600" 
               data-container-id="{{ $containerId ?? '' }}">
                Next
            </a>
        @else
            <span class="px-4 py-2 bg-gray-300 text-gray-600 rounded-md cursor-not-allowed">Next</span>
        @endif
    </nav>
@endif --}}

@if ($paginator->hasPages())
    <nav class="flex justify-center space-x-4 mt-4">
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Show More
            </a>
        @else
            <span class="px-4 py-2 bg-gray-300 text-gray-600 rounded-md cursor-not-allowed">Show More</span>
        @endif
    </nav>
@endif


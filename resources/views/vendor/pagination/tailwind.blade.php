@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <div class="hidden sm:flex sm:items-center sm:justify-center sm:space-x-2">
                <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm space-x-2" aria-hidden="true">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center w-9 h-9 text-sm text-gray-400 border border-gray-200 rounded-full justify-center p-0">&laquo;</span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center w-9 h-9 text-sm text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 justify-center p-0">&laquo;</a>
                    @endif
                </span>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm space-x-2">
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="inline-flex items-center px-3 py-1 text-sm text-gray-500 border border-gray-200">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="inline-flex items-center w-9 h-9 text-sm font-medium text-white bg-primary border border-primary rounded-full justify-center p-0">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center w-9 h-9 text-sm text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 justify-center p-0">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </span>
            </div>

            <div>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center w-9 h-9 text-sm text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 justify-center p-0">&raquo;</a>
                @else
                    <span class="inline-flex items-center w-9 h-9 text-sm text-gray-400 border border-gray-200 rounded-full justify-center p-0">&raquo;</span>
                @endif
            </div>
        </div>

        {{-- Mobile View --}}
        <div class="flex sm:hidden justify-center w-full space-x-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-3 py-1 text-sm text-gray-400 border border-gray-200 rounded-button">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-3 py-1 text-sm text-gray-700 bg-white border border-gray-200 rounded-button">Previous</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-3 py-1 text-sm text-gray-700 bg-white border border-gray-200 rounded-button">Next</a>
            @else
                <span class="inline-flex items-center px-3 py-1 text-sm text-gray-400 border border-gray-200 rounded-button">Next</span>
            @endif
        </div>
    </nav>
@endif

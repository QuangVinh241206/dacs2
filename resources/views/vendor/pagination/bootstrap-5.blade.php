@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center">
        <div class="d-flex d-sm-none justify-content-center">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item mx-1 disabled" aria-disabled="true">
                        <span class="page-link rounded-circle d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;padding:0;">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item mx-1">
                        <a class="page-link rounded-circle d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;padding:0;" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev">@lang('pagination.previous')</a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item mx-1">
                        <a class="page-link rounded-circle d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;padding:0;" href="{{ $paginator->nextPageUrl() }}"
                            rel="next">@lang('pagination.next')</a>
                    </li>
                @else
                    <li class="page-item mx-1 disabled" aria-disabled="true">
                        <span class="page-link rounded-circle d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;padding:0;">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none d-sm-flex justify-content-center">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item mx-1 disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link rounded-circle d-flex align-items-center justify-content-center"
                            aria-hidden="true" style="width:38px;height:38px;padding:0;">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item mx-1">
                        <a class="page-link rounded-circle d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;padding:0;" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            aria-label="@lang('pagination.previous')">&lsaquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item mx-1 disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item mx-1 active" aria-current="page"><span
                                        class="page-link rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:38px;height:38px;padding:0;">{{ $page }}</span></li>
                            @else
                                <li class="page-item mx-1"><a
                                        class="page-link rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:38px;height:38px;padding:0;" href="{{ $url }}">{{ $page }}</a></li>
                            @endif

                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item mx-1">
                        <a class="page-link rounded-circle d-flex align-items-center justify-content-center"
                            style="width:38px;height:38px;padding:0;" href="{{ $paginator->nextPageUrl() }}" rel="next"
                            aria-label="@lang('pagination.next')">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item mx-1 disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link rounded-circle d-flex align-items-center justify-content-center"
                            aria-hidden="true" style="width:38px;height:38px;padding:0;">&rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
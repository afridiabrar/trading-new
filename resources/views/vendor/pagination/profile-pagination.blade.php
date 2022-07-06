@if ($paginator->hasPages())
    <div class="clearfix justify-content-center text-center">
        <div class="hint-text">Showing <b>{{ $paginator->currentPage() }}</b> out of <b>{{ $paginator->total() }}</b> entries</div>
        <ul class="pagination justify-content-center text-center">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><a class="page-link disabled">Pre</a></li>
            @else
                <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link">Pre</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><a class="page-link disabled">{{ $element }}</a></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active"><a class="page-link disabled">{{ $page }}</a></li>
                            @else
                                <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                            @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link">Next</a></li>
            @else
                <li class="page-item disabled"><a class="page-link disabled">Next</a></li>
            @endif
        </ul>
    </div>
@endif

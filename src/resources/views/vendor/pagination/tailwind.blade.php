@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination-custom">
        {{-- 前へボタン --}}
        @if ($paginator->onFirstPage())
            <span class="page-arrow disabled">&lt;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-arrow">&lt;</a>
        @endif

        {{-- ページ番号 --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-number disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-number active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-number">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- 次へボタン --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-arrow">&gt;</a>
        @else
            <span class="page-arrow disabled">&gt;</span>
        @endif
    </nav>
@endif
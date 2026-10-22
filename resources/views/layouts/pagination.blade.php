@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Tombol Previous --}}
        @if ($paginator->onFirstPage())
            <span>‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">‹</a>
        @endif

        {{-- Elemen Halaman --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span>...</span>
            @else
                {{-- Array Dari Halaman --}}
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Tombol Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">›</a>
        @else
            <span>›</span>
        @endif
    </div>
@endif
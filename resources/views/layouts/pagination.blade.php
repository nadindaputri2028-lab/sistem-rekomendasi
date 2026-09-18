@if ($paginator->hasPages())
<div class="pagination">
@if ($paginator->onFirstPage()) <span>‹</span> @else <a href="{{ $paginator->previousPageUrl() }}">‹</a> @endif
@foreach ($elements as $element)
@if (is_string($element)) <span>...</span>
@else @foreach ($element as $page => $url) @if ($page == $paginator->currentPage()) <span class="active">{{ $page }}</span> @else <a href="{{ $url }}">{{ $page }}</a> @endif @endforeach @endif
@endforeach
@if ($paginator->hasMorePages()) <a href="{{ $paginator->nextPageUrl() }}">›</a> @else <span>›</span> @endif
</div>
@endif

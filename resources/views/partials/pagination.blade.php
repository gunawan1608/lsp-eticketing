@if ($paginator->hasPages())
    @php
        $start = max(1, $paginator->currentPage() - 1);
        $end = min($paginator->lastPage(), $paginator->currentPage() + 1);
    @endphp

    <div class="pager">
        <div class="pager__info">
            Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
        </div>

        <div class="pager__actions">
            @unless ($paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-secondary">Sebelumnya</a>
            @endunless

            @for ($page = $start; $page <= $end; $page++)
                @if ($page === $paginator->currentPage())
                    <span class="pager__page is-active">{{ $page }}</span>
                @else
                    <a href="{{ $paginator->url($page) }}" class="pager__page">{{ $page }}</a>
                @endif
            @endfor

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-secondary">Berikutnya</a>
            @endif
        </div>
    </div>
@endif

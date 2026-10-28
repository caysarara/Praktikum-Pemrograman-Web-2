@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Navigasi halaman">
        <ul class="pagination-list">
            {{-- Sebelumnya --}}
            @if ($paginator->onFirstPage())
                <li><span class="page-item disabled" aria-disabled="true">&laquo; Sebelumnya</span></li>
            @else
                <li><a class="page-item" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Sebelumnya</a></li>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="page-item disabled">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="page-item active" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a class="page-item" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Berikutnya --}}
            @if ($paginator->hasMorePages())
                <li><a class="page-item" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya &raquo;</a></li>
            @else
                <li><span class="page-item disabled" aria-disabled="true">Berikutnya &raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif

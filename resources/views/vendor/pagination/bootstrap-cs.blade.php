@if ($paginator->hasPages())
    <nav class="wow animated fadeInDown align-items-center d-flex justify-content-center">
        <ul class="pagination blog align-items-center">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link rounded-pill px-4 text-uppercase orange border-0 text-primary-y fw-medium mx-3 disabled" href="javascript:;" aria-disabled="true">
                        <i class="fa fa-arrow-left-long me-2"></i> <span>Back</span>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded-pill px-4 text-uppercase orange border-0 text-primary-y fw-medium mx-3" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fa fa-arrow-left-long me-2"></i> <span>Back</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item">
                        <a class="page-link border-0 text-black fw-medium px-2 fs-20 disabled" href="javascript:;">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a class="page-link border-0 text-primary-y fw-medium px-2 fs-4" href="javascript:;">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link border-0 text-black fw-medium px-2 fs-20" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link btn btn-primary-y rounded-pill py-2 px-4 text-uppercase border-0 mx-3" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span>Next</span> <i class="fa fa-long-arrow-right ms-2"></i>
                    </a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link btn btn-primary-y rounded-pill py-2 px-4 text-uppercase border-0 mx-3 disabled" href="javascript:;" aria-disabled="true">
                        <span>Next</span> <i class="fa fa-long-arrow-right ms-2"></i>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif

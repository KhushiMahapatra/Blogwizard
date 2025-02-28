@if ($paginator->hasPages())


        <div class="col-lg-6 text-center">
            <nav class="navigation pagination d-inline-block">
                <div class="nav-links">
            {{-- <span class="page-link">@lang('pagination.previous')</span> --}}
     <a class="prev page-numbers" href="#">Prev</a>
                </li>
            @else
                <li class="page-item">

                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="prev page-numbers" href="{{ $paginator->nextPageUrl() }}">Prev</a>
                    <a class="next page-numbers" >Next</a>
                    <a class="page-link"  rel="next">@lang('pagination.next')</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">@lang('pagination.next')</span>
                </li>
            @endif
        </div>
    </nav>
</div>

</div>
@endif

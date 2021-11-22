@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            
            {{-- First Page Link and Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}">&laquo;</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))

                    {{-- 定数よりもページ数が多い時 --}}
                    @if ($paginator->lastPage() > config("const.paginate.link_num"))

                        {{-- 現在ページが表示するリンクの中心位置よりも左の時 --}}
                        @if ($paginator->currentPage() <= floor(config("const.paginate.link_num") / 2))
                            <?php
                                $start_page = 1;
                                $end_page = config("const.paginate.link_num");
                            ?>
                        
                        {{-- 現在ページが表示するリンクの中心位置よりも右の時 --}}
                        @elseif ($paginator->currentPage() > $paginator->lastPage() - floor(config("const.paginate.link_num") / 2))
                            <?php
                                $start_page = $paginator->lastPage() - (config("const.paginate.link_num") - 1);
                                $end_page = $paginator->lastPage();
                            ?>
                        
                        {{-- 現在ページが表示するリンクの中心位置の時 --}}
                        @else
                            <?php
                                $start_page = $paginator->currentPage() - floor(config("const.paginate.link_num") / 2);
                                $end_page = $paginator->currentPage() + floor(config("const.paginate.link_num") / 2);
                            ?>
                        @endif

                    {{-- 定数よりもページ数が少ない場合 --}}
                    @else
                        <?php
                            $start_page = 1;
                            $end_page = $paginator->lastPage();
                        ?>
                    @endif

                    {{-- 処理部分 --}}
                    @for ($i = $start_page; $i <= $end_page; $i++)
                        @if ($i == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endfor
                @endif
            @endforeach

            {{-- Next Page Link and Last Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

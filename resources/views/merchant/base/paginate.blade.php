
    <table width="100%" height="22" border="0" cellspacing="0" cellpadding="0" class="page_box">
        <tbody>
        <td>
            <td align="left">&nbsp;共{{$paginator->count()}}个记录</td>
            <td align="center">共{{ceil($paginator->count()/$paginator->perPage())}}頁</td>
            <td align="right">
            @if ($paginator->onFirstPage())
                <span aria-hidden="true"> 前一頁『 </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"> 前一頁『 </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span>{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="cur">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"> 』后一頁</a>
            @else
                <span aria-hidden="true"> 』后一頁</span>
            @endif
            </td>
        </tr>
        </tbody>
    </table>


@extends('merchant.base.main')
@section('content')
<!--===================================================-->
<div id="page-content">
    <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
        <tbody><tr>
            <td width="5" height="100%" bgcolor="#4F4F4F"></td>
            <td class="c">
                <table border="0" cellspacing="0" class="main">
                    <tbody>
                    <tr>
                        <td width="12"><img src="{{asset('img/merchant/tab_03.gif')}}" alt=""></td>
                        <td background="{{asset('img/merchant/tab_05.gif')}}" align="right">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                <tr>
                                    <td width="17"><img src="{{asset('img/merchant/tb.gif')}}" width="16" height="16"></td>
                                    <td width="99%" align="left"><font style="font-weight:bold" color="#344B50">&nbsp;歷史開奬結果-{{$game->title}}</font></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td background="{{asset('img/merchant/tab_05.gif')}}" align="right">
                            <select class="lottery-games-option" id="lt">
                                @php
                                    $merchant_games = Session::get(config('site.merchant_game_key'));
                                @endphp
                                @foreach($merchant_games as $_game)
                                <option value="{{$_game['id']}}" {{$_game['id']==$game->id ? 'selected' : ''}}>{{$_game['title']}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td width="16"><img src="{{asset('img/merchant/tab_07.gif')}}" alt=""></td>
                    </tr>
                    <tr>
                        <td class="t"></td>
                        <td colspan="2" class="c">
                            <!-- strat -->
                            <table border="0" cellspacing="0" class="t_odds_1" style="margin-top:4px;">
                                <tbody>
                                <tr class="tr_top">
                                    <td width="55px">期數</td>
                                    <td width="124px">開獎時間</td>
                                    @foreach($options as $option)
                                    <td {{count($option['children']) > 1 ? 'colspan='.count($option['children']) : ''}}>{{$option['text']}}</td>
                                        @endforeach
                                </tr>
                                @foreach($lotteries as $lottery)
                                <tr class="td_text" onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#FFFFA2'" style="">
                                    <td>{{$lottery->issue}}</td>
                                    <td>{{$lottery->lotteryTime()}}</td>
                                    @foreach($options as $option)
                                        @foreach($option['children'] as $child)
                                            @php
                                                $value = isset($lottery->{$child['key']}) ? $lottery->{$child['key']} : '';
                                                $value = !empty($value) && isset($child['trans']) ? __('lottery.'.$value) : $value;
                                                $style = '';
                                                if(isset($child['style'])){
                                                    if(is_array($child['style']) && isset($child['style']['class'])){
                                                        $style = 'class='.$child['style']['class'];
                                                        if(isset($child['style']['merge']) && $child['style']['merge']){
                                                            $style .=$value ;
                                                        }
                                                    }else{
                                                        $style = 'class="'.$child['style'].'"';
                                                    }
                                                }
                                            @endphp
                                            <td {{$style}}>
                                                @if(!isset($child['text']) || $child['text'])
                                                    {!! $value !!}
                                                    @endif
                                            </td>
                                        @endforeach
                                    @endforeach
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                        <td width="12"><img src="{{asset('img/merchant/tab_18.gif')}}" alt=""></td>
                        <td colspan="2" align="right" class="f">
                            {{$lotteries->appends(['game'=>$game->id])->links('merchant.base.paginate')}}
                        </td>
                        <td width="16"><img src="{{asset('img/merchant/tab_20.gif')}}" alt=""></td>
                    </tr>

                    </tbody>
                </table>
            </td><td width="5" bgcolor="#4F4F4F"></td>

        </tr>
        <tr>
            <td height="5" bgcolor="#4F4F4F"></td>
            <td bgcolor="#4F4F4F"></td>
            <td height="5" bgcolor="#4F4F4F"></td>
        </tr>
        </tbody>
    </table>
</div>
@endsection

@section('script')
    <script>
        $(function () {
            $(document).delegate('.lottery-games-option','change', function () {
                var option = $(this).children("option:selected");
                var _link = '{{route('merchant.lottery')}}?game='+option.attr('value');
                pjax_redirect(_link);
            });
        })
    </script>
@endsection
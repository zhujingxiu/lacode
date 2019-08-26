@extends('merchant.base.main')
@section('content')
    <div id="page-content">
        <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
            <tbody><tr>
                <td width="5" height="100%" bgcolor="#4F4F4F"></td>
                <td class="c"><table border="0" cellspacing="0" class="main">
                        <tbody><tr>
                            <td width="12"><img src="{{asset('img/merchant/tab_03.gif')}}" alt=""></td>
                            <td background="{{asset('img/merchant/tab_05.gif')}}">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td width="80">
                                            <select id="det4" name="det4" onchange="FromSubmit();">
                                                <option value="0" selected="selected">--全选--</option>
                                                <option value="1">已結算</option>
                                                <option value="2">未結算</option>
                                            </select>
                                        </td>
                                        <td width="100" align="right">
                                            <select name="lt" id="lt" onchange="FromSubmit();">
                                                <option style="color:Blue" selected="selected" value="0">全部</option>
                                                @php
                                                    $merchant_games = Session::get(config('site.merchant_game_key'));
                                                @endphp
                                                @foreach($merchant_games as $_game)
                                                    <option value="{{$_game['id']}}">{{$_game['title']}}</option>
                                                @endforeach

                                            </select>
                                        </td>
                                        <td width="95">
                                            <input id="startDate" name="startDate" value="{{date('Y-m-d')}}" onfocus="WdatePicker({el:'startDate'})">
                                        </td>
                                        <td>—</td>
                                        <td width="95">
                                            <input id="endDate" name="endDate" value="{{date('Y-m-d')}}" onfocus="WdatePicker({el:'endDate'})">

                                        </td>
                                        <td width="65" align="right">查詢：</td>
                                        <td>
                                            <select id="FindType">
                                                <option value="3">會員帳號：</option>
                                            </select>
                                            &nbsp;
                                            <input type="text" maxlength="30" id="searchName" style="width:100px;"  class="'inp1MM'">
                                            &nbsp;
                                            <input name="Find_VN" type="button" class="inputa" onclick="FromSubmit()" value="查詢">
                                        </td>
                                    </tr>
                                    </tbody></table></td>
                            <td width="16"><img src="{{asset('img/merchant/tab_07.gif')}}" alt=""></td>
                        </tr>
                        <tr>
                            <td class="t"></td>
                            <td class="c"><!-- strat -->

                                <table border="0" cellspacing="0" class="conter">
                                    <tbody>
                                    <tr class="tr_top">
                                        <td width="180">注單號碼/時間</td>
                                        <td width="120">下注類型</td>
                                        <td width="80">帳號</td>
                                        <td>下注明細</td>
                                        <td>會員下注</td>
                                        <td>輸贏結果</td>
                                        <td width="190">基本操作</td>
                                    </tr>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{$order->game->title}}<br>
                                                <font color="#009933">{{$order->issue}}期</font>
                                            </td>
                                            <td>{{$order->member->name}}</td>
                                            <td></td>
                                            <td>{{$order->amount}}</td>
                                            <td>
                                                @if($order->status)
                                                    {{$order->profit}}
                                                    @else
                                                    <span style="color:#0000FF">『 未結算 』</span>
                                                    @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                        @empty
                                    <tr>
                                        <td align="center" colspan="8"><font color="red"><b>當前沒有數據······</b></font></td>
                                    </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                                <!-- end -->
                            </td>
                            <td class="r"></td>
                        </tr>
                        <tr>
                            <td width="12"><img src="{{asset('img/merchant/tab_18.gif')}}" alt=""></td>
                            <td class="f" align="right">
                                {{$orders->appends(['game'=>request('game_id')])->links('merchant.base.paginate')}}
                            </td>
                            <td width="16"><img src="{{asset('img/merchant/tab_20.gif')}}" alt=""></td>
                        </tr>
                        </tbody></table>
                </td><td width="5" bgcolor="#4F4F4F"></td>

            </tr>
            <tr>
                <td height="5" bgcolor="#4F4F4F"></td>
                <td bgcolor="#4F4F4F"></td>
                <td height="5" bgcolor="#4F4F4F"></td>
            </tr>
            </tbody></table>
    </div>
    @endsection

@section('script')
    <script type="text/javascript" src="{{asset('plugins/My97DatePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/My97DatePicker/lang/zh-tw.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    @endsection
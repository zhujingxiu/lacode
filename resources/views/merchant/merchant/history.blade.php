@extends('merchant.base.main')
@section('content')
    <div id="page-content">
        <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
            <tbody><tr>
                <td width="5" height="100%" bgcolor="#4F4F4F"></td>
                <td class="c">
                    <table border="0" cellspacing="0" class="main">
                        <tbody><tr>
                            <td width="12"><img src="{{asset('img/merchant/tab_03.gif')}}" alt=""></td>
                            <td background="{{asset('img/merchant/tab_05.gif')}}">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr>
                                        <td width="17"><img src="{{asset('img/merchant/tb.gif')}}" width="16" height="16"></td>
                                        <td><font style="font-weight:bold" color="#344B50">資料變更記錄-{{$merchant->nick_name}}</font></td>
                                        <td align="right" width="60"><img src="{{asset('img/merchant/fh.gif')}}">&nbsp;<a href="javascript:history.go(-1);">返囬</a></td>
                                    </tr>
                                    </tbody></table>
                            </td>
                            <td width="16"><img src="{{asset('img/merchant/tab_07.gif')}}" alt=""></td>
                        </tr>
                        <tr>
                            <td class="t"></td>
                            <td class="c">
                                <!-- strat -->
                                <table border="0" cellspacing="0" class="conter tableStriped">
                                    <tbody><tr class="tr_top">
                                        <td width="5%">ID</td>
                                        <td>變更時間</td>
                                        <td>變更類別</td>
                                        <td>原始值</td>
                                        <td>變更值</td>
                                        <td>變更人</td>
                                        <td>IP</td>
                                        <td>IP歸屬</td>
                                    </tr>
                                    @forelse($histories as $history)
                                    <tr align="center" >
                                        <td width="30">1</td>
                                        <td>{{$history->created_at}}</td>
                                        <td>{{$history->action}}</td>
                                        <td>{{$history->data}}</td>
                                        <td>{{$history->request}}</td>
                                        <td>{{$history->merchant->nick_name}}</td>
                                        <td>{{$history->ip}}</td>
                                        <td>{{$history->location}} </td>
                                    </tr>
                                        @empty
                                    <tr><td colspan="8"></td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!-- end -->
                            </td>
                            <td class="r"></td>
                        </tr>
                        <tr>
                            <td width="12"><img src="/img/merchant/tab_18.gif" alt=""></td>
                            <td align="right" class="f">
                                {{$histories->links('merchant.base.paginate')}}
                            </td>
                            <td width="16"><img src="/img/merchant/tab_20.gif" alt=""></td>
                        </tr>
                        <tr>
                            <td width="12"><img src="{{asset('img/merchant/tab_18.gif')}}" alt=""></td>
                            <td class="f" align="center">註意：脩改記錄最少被保畱15天。</td>
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
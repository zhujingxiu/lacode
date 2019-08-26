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
                                        <td>&nbsp;<font style="font-weight:bold" color="#344B50">登陸日誌</font></td>
                                        <td align="right"><img src="{{asset('img/merchant/fh.gif')}}">&nbsp;<a href="javascript:history.go(-1);">返囬</a></td>
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
                                        <td width="4%">ID</td>
                                        <td width="38%">登陸時間</td>
                                        <td width="20%">IP</td>
                                        <td width="38%">IP歸屬</td>

                                    </tr>
                                    @forelse($logs as $log)
                                    <tr align="center" >
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$log->created_at}}</td>
                                        <td>{{$log->ip}}</td>
                                        <td>{{$log->locate}}</td>
                                    </tr>
                                        @empty
                                        <tr><td colspan="4">当前没有记录</td></tr>
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
                                {{$logs->links('merchant.base.paginate')}}
                            </td>
                            <td width="16"><img src="{{asset('img/merchant/tab_20.gif')}}" alt=""></td>
                        </tr>
                        <tr>
                            <td width="12"><img src="{{asset('img/merchant/tab_18.gif')}}" alt=""></td>
                            <td class="f" align="center">註意：登陸日誌最少被保畱7天、超過7天部分最多保留最後20筆。</td>
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
            </tbody>
        </table>
    </div>
    @endsection
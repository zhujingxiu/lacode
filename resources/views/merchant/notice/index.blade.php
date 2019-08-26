@extends('merchant.base.main')
@section('content')
    <div id="page-content">
        <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
            <tbody>
            <tr>
                <td width="5" height="100%" bgcolor="#4F4F4F"></td>
                <td class="c">
                    <table border="0" cellspacing="0" class="main">
                        <tbody>
                        <tr>
                            <td width="12"><img src="{{asset('img/merchant/tab_03.gif')}}" alt=""></td>
                            <td background="{{asset('img/merchant/tab_05.gif')}}">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr>
                                        <td width="16"><img src="{{asset('img/merchant/tb.gif')}}" width="16" height="16"></td>
                                        <td><font style="font-weight:bold" color="#344B50">&nbsp;公告設置</font></td>
                                        <td align="right" width="18"><img src="{{asset('img/merchant/22.gif')}}" width="14" height="14"></td>
                                        <td align="right" width="50"><a href="{{route('merchant.notice-create')}}">新增公告</a></td>
                                    </tr>
                                    </tbody></table>
                            </td>
                            <td width="16"><img src="{{asset('img/merchant/tab_07.gif')}}" alt=""></td>
                        </tr>
                        <tr>
                            <td class="t"></td>
                            <td class="c">
                                <!-- strat -->
                                <table border="1" cellspacing="0" class="conter tableStriped" style="width:100%;margin:2 auto">
                                    <tbody><tr class="tr_top">
                                        <td width="90">ID</td>
                                        <td width="12%">貼出時間</td>
                                        <td>消息詳情</td>
                                        <td width="60">提示窗</td>
                                        <td width="60">代理公告 </td>
                                        <td width="60">會員公告</td>
                                        <td width="100">基本操作</td>
                                    </tr>
                                    @forelse($notices as $notice)
                                    <tr align="center" >
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$notice->created_at}}</td>
                                        <td class="left_p6" align="center">{{$notice->content}}</td>
                                        <td>
                                            @if($notice->modal==1)
                                            <span class="oddsalai">啟用</span>
                                            @else
                                            <span class="red">關閉</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($notice->merchant==1)
                                                <span class="oddsalai">啟用</span>
                                            @else
                                                <span class="red">關閉</span>
                                            @endif</td>
                                        <td>
                                            @if($notice->member==1)
                                                <span class="oddsalai">啟用</span>
                                            @else
                                                <span class="red">關閉</span>
                                            @endif
                                        </td>
                                        <td>
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                <tr>
                                                    <td class="nones" width="14" height="18"><img src="{{asset('img/merchant/edt.gif')}}"></td>
                                                    <td class="nones" width="30"><a href="{{route('merchant.notice-update',$notice)}}">修改</a></td>
                                                    <td class="nones" width="15"><img src="{{asset('img/merchant/edit.gif')}}"></td>
                                                    <td class="nones" width="30"><a data-link="{{route('merchant.notice-delete',$notice)}}" href="javascript:void(0)" class="delItem">刪除</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                        @empty
                                        <tr><td colspan="7">当前没有记录</td></tr>
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
                                {{$notices->links('merchant.base.paginate')}}
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
            $('.delItem').click(function () {
                if(confirm('確定刪除嗎？')){
                    var _url = $(this).data('link');
                    $.getJSON(_url,{_t:Math.random()},function (json) {
                        if(json.error_code>0){
                            layer.alert(json.msg,{icon:5});
                        }else{
                            if(json.hasOwnProperty('data') && json.data.hasOwnProperty('redirect')){
                                pjax_redirect(json.data.redirect)
                            }else{
                                layer.msg(json.msg);
                            }
                        }
                    })
                }
            })
        })

    </script>
    @endsection
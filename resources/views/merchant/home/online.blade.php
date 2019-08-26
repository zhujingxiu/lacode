@extends('merchant.base.main')
@section('content')
<div id="page-content">
    <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
        <tbody><tr>
            <td width="5" height="100%" bgcolor="#4F4F4F"></td>
            <td class="c">
                <table border="0" cellspacing="0" class="main">
                    <tbody>
                    <tr>
                        <td width="12"><img src="{{asset('img/merchant/tab_03.gif')}}" alt=""></td>
                        <td background="{{asset('img/merchant/tab_05.gif')}}">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>
                                    <td width="17"><img src="{{asset('img/merchant/tb.gif')}}" width="16" height="16"></td>
                                    <td width="99%"><font style="font-weight:bold" color="#344B50">&nbsp;在线統計</font></td>
                                </tr>
                                </tbody></table>
                        </td>
                        <td width="16"><img src="{{asset('img/merchant/tab_07.gif')}}" alt=""></td>
                    </tr>
                    <tr>
                        <td class="t"></td>
                        <td class="c"><!-- strat -->
                            <table border="0" cellspacing="0" class="conter tableStriped">
                                <tbody>
                                <tr class="tr_top">
                                    <td>管理</td>
                                    <td>分公司</td>
                                    <td>股東</td>
                                    <td>總代理</td>
                                    <td>代理</td>
                                    <td>会员</td>
                                </tr>
                                <tr style="height:15px">
                                    <td align="center">
                                        <a href="{{route('merchant.online')}}?role=admin">
                                            <font color="#000000" style="font-size:114%"><strong>{{$count['admin']}}</strong></font>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{route('merchant.online')}}?role=company">
                                            <font color="#000000" style="font-size:114%"><strong>{{$count['company']}}</strong></font>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{route('merchant.online')}}?role=shareholder">
                                            <font color="#000000" style="font-size:114%"><strong>{{$count['shareholder']}}</strong></font>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{route('merchant.online')}}?role=agent">
                                            <font color="#000000" style="font-size:114%"><strong>{{$count['agent']}}</strong></font>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{route('merchant.online')}}?role=proxy">
                                            <font color="#000000" style="font-size:114%"><strong>{{$count['proxy']}}</strong></font>
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="{{route('merchant.online')}}">
                                            <font color="#000000" style="font-size:114%"><strong>{{$count['member']}}</strong></font>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                            @if($role=='member')
                            <table border="0" cellspacing="0" class="conter tableStriped">
                                <tbody>
                                <tr class="tr_top">
                                    <td>帳號</td>
                                    <td>名稱</td>
                                    <td>当前位置</td>
                                    <td width="12%">可用金額</td>
                                    <td width="12%">下註金额</td>
                                    <td width="12%">今天输赢</td>
                                    <td width="7%">刷新時間</td>
                                    <td width="10%">IP</td>
                                    <td width="10%">IP歸屬</td>
                                    <td width="60">基本操作</td>
                                </tr>
                                @forelse($records as $record)
                                    <tr align="center">
                                        @php
                                            $last_access = $record->history ? $record->history->created_at : $record->last_login;
                                            $auto_offline = time() - strtotime($last_access) > 30*60;
                                        @endphp
                                        <td>{{$record->name}}
                                            @if($record->merchant->role->code !='proxy')
                                            ({{$record->merchant->name}} {{$record->merchant->role->title}}直属会员)
                                                @endif
                                        </td>
                                        <td>{{$record->nick_name}}</td>


                                        @if($auto_offline)
                                            <td colspan="4">
                                                <img src="{{asset('img/merchant/del.gif')}}" alt="">
                                                該會員30分鍾未有操作，系統定義不在線。
                                            </td>
                                            @else
                                            <td>{{$record->history ? $record->history->note : ''}}</td>
                                            <td>{{$record->info->balance}}</td>
                                            <td></td>
                                            <td></td>
                                        @endif

                                        <td>{{$last_access}}</td>
                                        <td>{{$record->last_ip}}</td>
                                        <td>
                                            @php
                                            $locate = $record->last_ip ? ip_locate($record->last_ip) : '';
                                            @endphp
                                            {{$locate ? $locate['region'].'.'.$locate['city'].'-'.$locate['isp'] : ''}}
                                        </td>
                                        <td>
                                            @if($auto_offline)
                                                自動踢出
                                                @else
                                                <img src="{{asset('img/merchant/55.gif')}}" width="14" height="14">
                                                <a href="javascript:void(0);" title="登出" class="getOut" data-role="{{$role}}" data-rel="{{$record->id}}">登出</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                <tr>
                                    <td align="center" colspan="9">
                                        <font color="red"><center><b>當前沒有用戶在線······</b></center></font>
                                    </td>
                                </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @else
                                <table border="0" cellspacing="0" class="conter tableStriped">
                                    <tbody>
                                    <tr class="tr_top">
                                        <td width="3%">ID</td>
                                        <td>帳號</td>
                                        <td>名稱</td>
                                        <td>当前位置</td>
                                        <td>可回收余额</td>
                                        <td width="7%">刷新時間</td>
                                        <td width="10%">IP</td>
                                        <td width="10%">IP歸屬</td>
                                        <td width="60">操作</td>
                                    </tr>
                                    @forelse($records as $record)
                                        <tr align="center">
                                            @php
                                                $last_access = $record->history ? $record->history->created_at : $record->last_login;
                                                $auto_offline = time() - strtotime($last_access) > 30*60;
                                            @endphp
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$record->name}} ( {{$record->role->title}}) </td>
                                            <td>{{$record->nick_name}}</td>

                                            @if($auto_offline)
                                                <td colspan="2">
                                                    <img src="{{asset('img/merchant/del.gif')}}" alt="">
                                                    該會員30分鍾未有操作，系統定義不在線。
                                                </td>
                                            @else
                                                <td>{{$record->history ? '后台'.$record->history->note : ''}}</td>
                                                <td>{{$record->info->balance}}</td>
                                                @endif
                                            <td>{{$last_access}}</td>
                                            <td>{{$record->last_ip}}</td>
                                            <td>
                                                @php
                                                    $locate = $record->last_ip ? ip_locate($record->last_ip) : '';
                                                @endphp
                                                {{$locate ? $locate['region'].'.'.$locate['city'].'-'.$locate['isp'] : ''}}
                                            </td>
                                            <td>@if($record->id != \Auth::guard('merchant')->user()->id)
                                                @if($auto_offline)
                                                    自動踢出
                                                @else
                                                    <img src="{{asset('img/merchant/55.gif')}}" width="14" height="14">
                                                    <a href="javascript:void(0);" title="登出" class="getOut" data-role="{{$role}}" data-rel="{{$record->id}}">登出</a>
                                                @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td align="center" colspan="9">
                                                <font color="red"><center><b>當前沒有用戶在線······</b></center></font>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                @endif
                            <!-- end -->
                        </td>
                        <td class="r"></td>
                    </tr>
                    <tr>
                        <td width="12"><img src="{{asset('img/merchant/tab_18.gif')}}" alt=""></td>
                        <td class="f" align="right">
                            {{$records->links('merchant.base.paginate')}}
                        </td>

                        <td width="16"><img src="{{asset('img/merchant/tab_20.gif')}}" alt=""></td>
                    </tr>

                    </tbody></table>
            </td><td width="2" bgcolor="#4F4F4F"></td>

        </tr>
        <tr>
            <td height="2" bgcolor="#4F4F4F"></td>
            <td bgcolor="#4F4F4F"></td>
            <td height="2" bgcolor="#4F4F4F"></td>
        </tr>
        </tbody></table>


</div>
@endsection

@section('script')
    <script>
        $(function () {
            $('.getOut').click(function () {
                var _role = $(this).data('role');
                var _user = $(this).data('rel');
                $.getJSON('{{route('merchant.user-offline')}}',{role:_role,user:_user,_t:Math.random()},function (json) {
                    if(json.code==1){
                        layer.alert(json.msg, {icon:5});
                    }else{
                        if(json.hasOwnProperty('data') && json.data.hasOwnProperty('redirect')){
                            pjax_redirect(json.data.redirect)
                        }else{
                            layer.msg(json.msg);
                        }
                    }
                })
            })
        })
    </script>
@endsection
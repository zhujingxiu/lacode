@extends('merchant.base.main')
@section('content')
    <div id="page-container">
        <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
            <tbody><tr>
                <td width="5" height="100%" bgcolor="#4F4F4F"></td>
                <td class="c">

                    <table border="0" cellspacing="0" class="main">
                        <tbody><tr>
                            <td width="12"><img src="/img/merchant/tab_03.gif" alt=""></td>
                            <td background="/img/merchant/tab_05.gif">

                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody><tr>
                                        <td width="17"><img src="/img/merchant/tb.gif" width="16" height="16"></td>
                                        <td><font style="font-weight:bold" color="#344B50">&nbsp;{{$role->title}}管理</font>
                                        </td>
                                        <td width="56%">
                                            @include('merchant.merchant.filter',['action'=>$filter_url])
                                        </td>
                                        <td align="right" width="18"><img src="/img/merchant/22.gif" width="14" height="14"></td>
                                        <td align="right" width="60"><a href="{{route('merchant.user-create',$role->code)}}">新增{{$role->title}}</a></td>
                                    </tr>
                                    </tbody>
                                </table>

                            </td>
                            <td width="16"><img src="/img/merchant/tab_07.gif" alt=""></td>
                        </tr>
                        <tr>
                            <td class="t"></td>
                            <td class="c">
                                <!-- strat -->
                                <table border="0" cellspacing="0" class="conter">
                                    <tbody><tr class="tr_top">
                                        <td width="30">在綫</td>
                                        <td width="5%">上級股東</td>
                                        <td width="6%">占成</td>
                                        <td width="7%">總代理</td>
                                        <td width="6%">占成</td>
                                        <td width="6%">名稱</td>
                                        <td>代理</td>
                                        <td>會員</td>
                                        <td>信用額度</td>
                                        <td>可用餘額</td>
                                        <td>新增日期</td>
                                        <td width="230">功能
                                        </td>
                                        <td width="30">補貨</td>
                                        <td width="40">狀態</td>
                                    </tr>
                                    @forelse($merchants as $merchant)
                                    <tr align="center" style="height: 22px;" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                        <td width="30">
                                            @if($merchant->online)
                                                <img src="/img/merchant/user_1.gif">
                                            @else
                                                <img src="/img/merchant/user_0.gif">
                                            @endif
                                        </td>
                                        <td>{{$merchant->parent->name}}</td>
                                        <td>0%</td>
                                        <td class="dfg bg_l">
                                            <a href="{{route('merchant.user-proxy')}}?parent={{$merchant->name}}" data-pjax="true">{{$merchant->name}}</a>
                                        </td>
                                        <td class="bg_l">{{$merchant->info->rate*1}}%</td>
                                        <td align="left">{{$merchant->nick_name}}</td>
                                        <td style="font-size:110%">
                                            <strong><a href="{{route('merchant.user-proxy')}}?parent={{$merchant->name}}" data-pjax="true">{{$merchant->proxy_count}}</a></strong>
                                        </td>
                                        <td style="font-size:110%">
                                            <strong><a href="{{route('merchant.member')}}?merchant={{$merchant->name}}" data-pjax="true">{{$merchant->member_count}}</a></strong>
                                        </td>
                                        <td align="right" style="font-size:104%;">{{$merchant->info->credit}}</td>
                                        <td align="right" style="font-size:104%;">{{$merchant->info->balance}}</td>
                                        <td>{{$merchant->created_at->format('Y-m-d')}}</td>
                                        <td>@include('merchant.merchant.option',['merchant'=>$merchant])</td>
                                        <td>
                                            @if($merchant->info->replenish)
                                                <img src="/img/merchant/img_1.gif">
                                            @else
                                                <img src="/img/merchant/img_0.gif">
                                            @endif
                                        </td>
                                        <td>@include('merchant.merchant.status',['merchant'=>$merchant])</td>
                                    </tr>
                                        @empty
                                            <tr align="center">
                                                <td colspan="16"><font color="red"><b>當前沒有數據······</b></font></td>
                                            </tr>
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
                                {{$merchants->links('merchant.base.paginate')}}
                            </td>
                            <td width="16"><img src="/img/merchant/tab_20.gif" alt=""></td>
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
            </tbody></table>
    </div>
    @endsection
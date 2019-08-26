@extends('merchant.base.main')

@section('content')
    <div id="page-content">

        <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
            <tbody><tr>
                <td width="5" height="100%" bgcolor="#4F4F4F"></td>
                <td class="c">
                    <table border="0" cellspacing="0" class="main">
                        <tbody><tr>
                            <td width="12"><img src="/img/merchant/tab_03.gif" alt=""></td>
                            <td background="/img/merchant/tab_05.gif">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td width="17"><img src="/img/merchant/tb.gif" width="16" height="16"></td>
                                        <td><font style="font-weight:bold" color="#344B50">&nbsp;會員管理</font></td>
                                        <td width="56%">
                                            @include('merchant.merchant.filter',['action'=>$filter_url])
                                        </td>
                                        <td align="right" width="18"><img src="/img/merchant/22.gif" width="14" height="14"></td>
                                        <td align="right" width="55"><a data-pjax="true" href="{{route('merchant.member-create')}}">新增會員</a></td>
                                        <td align="right" width="18"><img src="/img/merchant/22.gif" width="14" height="14"></td>
                                        <td align="right" width="80"><a data-pjax="true" href="{{route('merchant.member-create')}}?rel=1">新增直屬會員</a></td>
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
                                        <td width="7%">會員類型</td>
                                        <td width="5%">上級代理</td>
                                        <td width="6%">占成</td>
                                        <td width="7%">會員</td>
                                        <td width="9%">名稱</td>
                                        <td>信用額度</td>
                                        <td>可用餘額</td>
                                        <td>新增日期</td>
                                        <td width="30">盤口</td>
                                        <td width="330">功能</td>
                                        <td width="40">狀態</td>
                                    </tr>
                                    @forelse($members as $member)
                                    <tr align="center" style="height: 22px;" onmouseover="this.style.backgroundColor='#FFFFA2'" onmouseout="this.style.backgroundColor=''">
                                        <td width="30">
                                            @if($member->online)
                                                <img src="/img/merchant/user_1.gif">
                                            @else
                                                <img src="/img/merchant/user_0.gif">
                                            @endif
                                        </td>
                                        <td>
                                            @if($member->merchant->role->code=='proxy')
                                                普通会员
                                            @else
                                                <font class="red">直屬{{$member->merchant->role->title}}</font>
                                            @endif
                                        </td>
                                        <td>{{$member->merchant->name}}</td>
                                        <td style="font-size:104%">{{$member->merchant->info->rate}}%</td>
                                        <td class="dfg bg_l">{{$member->name}}</td>
                                        <td align="left">{{$member->nick_name}}</td>
                                        <td align="right" style="font-size:104%;">{{$member->info->credit}}</td>
                                        <td align="right" style="font-size:104%;">{{$member->info->balance}}</td>
                                        <td>{{$member->created_at->format('Y-m-d')}}</td>
                                        <td>{{strtoupper($member->info->roulette)}}盤</td>
                                        <td>
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                <tr>
                                                    <td class="nones" width="14" height="18"><img src="/img/merchant/edt.gif"></td>
                                                    <td class="nones" width="30">
                                                        <a href="{{route('merchant.member-rebate', $member)}}"><font color="#344B50">退水</font></a>
                                                    </td>
                                                    <td class="nones" width="15"><img src="/img/merchant/edit.gif"></td>
                                                    <td class="nones" width="30">
                                                        <a href="{{route('merchant.member-edit', $member)}}"><font color="#344B50">修改</font></a>
                                                    </td>
                                                    <td class="nones" width="16"><img src="/img/merchant/55.gif"></td>
                                                    <td class="nones" width="30">
                                                        <a href="{{route('merchant.member-log', $member)}}"><font color="#344B50">日誌</font></a>
                                                    </td>
                                                    <td class="nones" width="16"><img src="/img/merchant/44.gif"></td>
                                                    <td class="nones" width="26">
                                                        <a href="{{route('merchant.member-history', $member)}}"><font color="#344B50">記錄</font></a>
                                                    </td>
                                                    <td class="nones" width="16"><img src="/img/merchant/del.gif"></td>
                                                    <td class="nones" width="26">
                                                        <a href="javascript:void(0)" onclick="locationFile1('aba868','1')">刪除</a></td>
                                                    <td class="nones" width="15"><img src="/img/merchant/edt.gif"></td>
                                                    <td class="nones" width="30">
                                                        <a href="{{route('merchant.member-recharge', $member)}}">充值</a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <input style="height:22px;padding: 0px 5px 2px 5px;" type="button" name="ut0" id="ut0" onclick="locationFile(0);" value="启用">
                                            <div id="oddsPops0" style="position:absolute;width:190px;display:none">
                                                <table border="0" cellspacing="0" class="t_odds" width="100%">
                                                    <tbody><tr class="tr_top">
                                                        <th align="right">修改賬戶狀態</th><th width="27%" align="right"><img src="/img/merchant/del.gif" onclick="diplaydiv(0);" title="关闭"></th>
                                                    </tr>
                                                    <tr class="text" style="height:35px;text-align:center">
                                                        <td id="showPas0" colspan="2">
                                                            <input name="lock0" type="radio" value="1" checked="checked" onclick="changeAjax(this.value,'aba868',2,0);">
                                                            启用&nbsp;
                                                            <input name="lock0" type="radio" value="2" onclick="changeAjax(this.value,'aba868',2,0);">
                                                            凍結&nbsp;
                                                            <input name="lock0" type="radio" value="3" onclick="changeAjax(this.value,'aba868',2,0);">
                                                            停用&nbsp;
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr align="center">
                                            <td colspan="15"><font color="red"><b>當前沒有數據······</b></font></td>
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
                            {{$members->links('merchant.base.paginate')}}
                            <td width="16"><img src="/img/merchant/tab_20.gif" alt=""></td>
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
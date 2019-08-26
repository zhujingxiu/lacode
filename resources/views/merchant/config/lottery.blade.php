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
                            <td background="{{asset('img/merchant/tab_05.gif')}}" align="right">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td width="17"><img src="{{asset('img/merchant/tb.gif')}}" width="16" height="16"></td>
                                        <td width="19%" align="left"><font style="font-weight:bold" color="#344B50">&nbsp;歷史開奬結果-{{$game->title}}</font></td>
                                        <td>
                                            批量操作：
                                            <input class="textb" style="width:70px;text-align:center" id="beforeDay" value="{{date('Y-m-d',strtotime('-7 day'))}}" onfocus="WdatePicker({el:'beforeDay'})">
                                            <input type="button" class="inputs" id="bulkDelete" value="確認刪除">
                                            <span class="odds">注：系統將保留選定日期后的開獎記錄。</span>
                                        </td>
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
                                <div style="margin: 0 auto">
                                <table border="0" cellspacing="0" class="t_odds_1" style="margin:5px 10px; max-width:45%;float: left;">
                                    <tbody>
                                    <tr class="tr_top">
                                        <td width="55px">期數</td>
                                        <td width="124px">開獎時間</td>

                                        <td {{count($openNumbers['children']) > 1 ? 'colspan='.count($openNumbers['children']) : ''}}>{{$openNumbers['text']}}</td>
                                        <td></td>
                                    </tr>
                                    @foreach($lotteries as $lottery)
                                        <tr class="td_text" onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#FFFFA2'" style="">
                                            <td>{{$lottery->issue}}</td>
                                            <td><span>{{$lottery->lotteryTime()}}</span></td>

                                            @foreach($openNumbers['children'] as $child)
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
                                                <td data-rel="numbers" data-key="{{$child['key']}}" {{$style}}>
                                                    @if(!isset($child['text']) || $child['text'])
                                                        {!! $value !!}
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td class="lotteryOptions" data-lottery="{{json_encode($lottery)}}">
                                                <table border="0" cellspacing="0" cellpadding="0" >
                                                    <tbody>
                                                    <tr>
                                                        <td class="nones" width="14" height="18"><img src="{{asset('img/merchant/edt.gif')}}"></td>
                                                        <td class="nones" width="30">
                                                            <a href="javascript:void(0)" class="issueEdit">修改</a>
                                                        </td>
                                                        <td class="nones" width="15"><img src="{{asset('img/merchant/edit.gif')}}"></td>
                                                        <td class="nones" width="30">
                                                            <a href="javascript:void(0)" class="issueDelete">刪除</a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                    <form action="{{route('merchant.config-lottery')}}" method="post" id="lottery-form">
                                        {{csrf_field()}}
                                        <input type="hidden" name="action" value="modify">
                                        <input type="hidden" name="game" value="{{$game->id}}">
                                        <table border="0" cellspacing="0" class="conter" style="margin-right:10px;max-width:20%;float: left;text-align: center">
                                            <tbody>
                                            <tr class="tr_top">
                                                <td width="110">開獎期數</td>
                                                <td class="inputOnMouse" align="center">
                                                    <input type="text" class="inp1MM" data-key="issue" name="issue" required placeholder="请输入期数">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="140">開獎時間</td>
                                                <td class="inputOnMouse" align="center">
                                                    <input type="text" class="inp1MM" data-key="open_time" name="open_time" value="{{now()}}">
                                                </td>
                                            </tr>
                                            @foreach($openNumbers['children'] as $child)
                                                <tr>
                                                    <td width="140">{{$child['title']}}</td>
                                                    <td class="inputOnMouse" align="center">
                                                        <input type="text" class="inp1MM" data-key="{{$child['key']}}" name="numbers[{{$child['key']}}]" required isDigits="true">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            <tr>
                                                <td>結算</td>
                                                <td><input type="checkbox" id="settle" name="settle" value="1"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="f" align="center">
                                                    <input type="button" class="inputs" value="確認提交" onclick='if (confirm("確認提交嗎？")) {$("#lottery-form").submit()}'>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </form>
                                    <table border="0" cellspacing="0" class="conter" style="max-width:33%; text-align: center;">
                                        <tr class="tr_top">
                                            <td width="20%">期數</td>
                                            <td colspan="3"><input id="resetIssue" type="text" class="text" /></td>
                                            <td width="15%">
                                                <input type="button" value="恢復未結算狀態" id="resetSettle" />
                                            </td>
                                        </tr>
                                        <tr><td colspan="5" align="center">最近20笔未结算</td></tr>
                                        <tr class="tr_top">
                                            <td width="20%">期數</td>
                                            <td>筆數</td>
                                            <td>未結算金額</td>
                                            <td width="15%">狀態</td>
                                            <td width="15%">基本操作</td>
                                        </tr>
                                    </table>
                                </div>
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
    <script type="text/javascript" src="{{asset('plugins/My97DatePicker/WdatePicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/My97DatePicker/lang/zh-tw.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-validation/localization/messages_zh_TW.js')}}"></script>
    <script src="{{asset('plugins/jquery-validation/customValidate.js')}}"></script>
    <script>
        $.validator.setDefaults({
            onkeyup: false,
            errorElement : 'span',
            errorClass : 'help-block',
            highlight : function(element) {
                $(element).addClass('has-error');
            },
            success : function(label, element) {
                $(element).removeClass('has-error');
                label.remove();
            },
            errorPlacement : function(error, element) {
                if(error.text().length>0)
                    layer.tips(error.text(), element,{tips: 2});
            }
        });
        $(function () {
            var _url = '{{route('merchant.config-lottery')}}';
            var _game_id = parseInt('{{$game->id}}');
            $(document).delegate('.lottery-games-option','change', function () {
                var option = $(this).children("option:selected");
                var _link = '{{route('merchant.config-lottery')}}?game='+option.attr('value');
                pjax_redirect(_link);
            });
            $('#bulkDelete').click(function () {
                var _day = $('#beforeDay').val();
                if (confirm(_day+"之前的開獎記錄將被刪除，確定嗎？")) {
                    $.post(_url, {
                        'action': 'clear',
                        'game': _game_id,
                        'day': _day,
                        '_t': Math.random()
                    }, function (json) {
                        if (json.code == 1) {
                            layer.alert(json.msg, {icon: 5});
                        } else {
                            if (json.hasOwnProperty('data') && json.data.hasOwnProperty('redirect')) {
                                pjax_redirect(json.data.redirect)
                            } else {
                                layer.msg(json.msg);
                            }
                        }
                    }, 'json')
                }
            });
            $('.issueDelete').click(function () {
                var _lottery = $(this).parentsUntil('.lotteryOptions').parent().data('lottery');
                var _issue = _lottery.issue;
                if (confirm(_issue+"的開獎記錄將被刪除，確定嗎？")) {
                    $.post(_url, {
                        'action': 'delete',
                        'game': _game_id,
                        'issue': _issue,
                        '_t': Math.random()
                    }, function (json) {
                        if (json.code == 1) {
                            layer.alert(json.msg, {icon: 5});
                        } else {
                            if (json.hasOwnProperty('data') && json.data.hasOwnProperty('redirect')) {
                                pjax_redirect(json.data.redirect)
                            } else {
                                layer.msg(json.msg);
                            }
                        }
                    }, 'json')
                }
            })
            $('.issueEdit').click(function () {
                var _lottery = $(this).parentsUntil('.lotteryOptions').parent().data('lottery');
                $.each($('#lottery-form input'),function () {
                    var _key = $(this).data('key');
                    if(_lottery.hasOwnProperty(_key)){
                        $(this).val(_lottery[_key]);
                    }
                })
            });

            $('#lottery-form').validate({
                //提交
                submitHandler : function(form){
                    $(form).ajaxSubmit({
                            dataType:'json',
                            success: function (json) {
                                layer.closeAll();
                                if(json.code==1){
                                    layer.alert(json.msg, {icon:5});
                                }else{
                                    if(json.hasOwnProperty('data') && json.data.hasOwnProperty('redirect')){
                                        pjax_redirect(json.data.redirect)
                                    }else{
                                        layer.msg(json.msg);
                                    }
                                }
                            },
                            error: function (json) {
                                if(json.responseJSON.error_code>0){
                                    var _html = [];
                                    var _errors = json.responseJSON.data.errors;
                                    for (var _key in _errors) {
                                        _html.push(_errors[_key])
                                    }
                                    console.log(_html)
                                    layer.msg(_html.join(),{icon:5})
                                }
                            }
                        }
                    );
                }
            });
            $('#resetSettle').click(function () {
                var _issue = $('#resetIssue').val();
                if(_issue == ''){
                    layer.alert('请输入要重置的期号');
                    return false;
                }
                if(confirm("確定恢復 第 "+_issue+" 期 注單嗎？")) {
                    $.post(_url, {
                        'action': 'resettle',
                        'game': _game_id,
                        'issue': _issue,
                        '_t': Math.random()
                    }, function (json) {
                        if (json.code == 1) {
                            layer.alert(json.msg, {icon: 5});
                        } else {
                            if (json.hasOwnProperty('data') && json.data.hasOwnProperty('redirect')) {
                                pjax_redirect(json.data.redirect)
                            } else {
                                layer.msg(json.msg);
                            }
                        }
                    }, 'json')
                }
            })
        })
    </script>
    @endsection
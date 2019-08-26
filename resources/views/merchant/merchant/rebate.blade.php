@extends('merchant.base.main')
@section('content')
    <div id="page-content">
        <form action="{{route('merchant.user-rebate', $merchant)}}" method="post" id="rebate-form">
            {{csrf_field()}}
            <table border="0" cellspacing="0" cellpadding="0" class="Main">
                <tbody>
                <tr>
                    <td class="Main_top_left"></td>
                    <td class="main_top">
                        <div>
                        <img style="margin-right:5px" src="{{asset('img/merchant/tb.gif')}}" width="16" height="16" alt="">
                        退水設定 -&gt;{{$merchant->role->title}}（<span style="font-weight:normal">{{$merchant->name}}</span>）
                            <div style="float: right">{{$merchant->role->title}}名稱：{{$merchant->nick_name}}</div>
                        </div>
                    </td>
                    <td class="Main_top_right"></td>
                </tr>

                <tr>
                    <td class="Main_left"></td>
                    <td class="Main_conter">
                        <!-- strat -->
                        <table border="0" cellspacing="0" cellpadding="0" class="tableTrait">
                            <tbody>
                            <tr class="traitTop">
                                <th colspan="8">
                                    大項快速設置【注意：設置高於上級最高限制時按最高可調】
                                </th>
                            </tr>
                            <tr class="traitTop Ct">
                                <td width="30%">調整項目</td>
                                <td width="5%"></td>
                                <td width="12%">A盤</td>
                                <td width="12%">B盤</td>
                                <td width="12%">C盤</td>
                                <td width="12%">單註限額</td>
                                <td width="12%">單期限額</td>
                                <td width="5%">…</td>
                            </tr>
                            <tr class="traitLine">
                                <td>特碼類(第一球、第二球、冠軍 …)</td>
                                <td class="traitSpecial"></td>
                                <td class="TD_TS1">
                                    <input type="text" data-rel="special-a" class="inputFocus">
                                </td>
                                <td><input type="text" data-rel="special-b" class="inputFocus"></td>
                                <td><input type="text" data-rel="special-c" class="inputFocus"></td>
                                <td><input type="text" data-rel="special-bet" class="inputFocus"></td>
                                <td><input type="text" data-rel="special-issue" class="inputFocus"></td>
                                <td class="TD_TS1">
                                    <input type="button" class="input2" data-trait="special" value="修改">
                                </td>
                            </tr>
                            <tr class="traitLine">
                                <td class="">兩面類(單雙、大小、龍虎 …)</td>
                                <td class="traitDouble"></td>
                                <td class="TD_TS2">
                                    <input type="text" data-rel="double-a" class="inputFocus">
                                </td>
                                <td><input type="text" data-rel="double-b" class="inputFocus"></td>
                                <td><input type="text" data-rel="double-c" class="inputFocus"></td>
                                <td><input type="text" data-rel="double-bet" class="inputFocus"></td>
                                <td><input type="text" data-rel="double-issue" class="inputFocus"></td>
                                <td class="TD_TS2">
                                    <input type="button" class="input2"  data-trait="double" value="修改">
                                </td>
                            </tr>
                            <tr class="traitLine">
                                <td>連碼類(任選二、任選三 …)</td>
                                <td class="traitSerial"></td>
                                <td class="TD_TS3">
                                    <input type="text" data-rel="serial-a" class="inputFocus">
                                </td>
                                <td><input type="text" data-rel="serial-b" class="inputFocus"></td>
                                <td><input type="text" data-rel="serial-c" class="inputFocus"></td>
                                <td><input type="text" data-rel="serial-bet" class="inputFocus"></td>
                                <td><input type="text" data-rel="serial-issue" class="inputFocus"></td>
                                <td class="TD_TS3">
                                    <input type="button" class="input2"  data-trait="serial" value="修改">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        @foreach($games as $game)
                        <div class="rebateGame">{{$game->title}}</div>
                        <table border="0" cellspacing="" cellpadding="0" class="tableRebate">
                            <tbody>
                            @foreach($game->options as $option)
                            <tr class="rebateLine" id="rebate-line-{{$option->id}}">
                                <td width="30%">{{$option->title}}</td>
                                <td width="5%" class="trait{{ucwords($option->trait)}}">{{trait_type($option->trait)}}</td>
                                @php
                                $_rebate = isset($merchant_rebates[$option->id]) ? $merchant_rebates[$option->id] : [];
                                $_parent_rebate = isset($parent_rebates[$option->id]) ? $parent_rebates[$option->id] : [];
                                $_a_limit = isset($_rebate['a_limit']) ? $_rebate['a_limit'] : '';
                                $_b_limit = isset($_rebate['b_limit']) ? $_rebate['b_limit'] : '';
                                $_c_limit = isset($_rebate['c_limit']) ? $_rebate['c_limit'] : '';
                                $_bet_limit = isset($_rebate['bet_limit']) ? $_rebate['bet_limit'] : '';
                                $_issue_limit = isset($_rebate['issue_limit']) ? $_rebate['issue_limit'] : '';

                                $_parent_a_limit = isset($_parent_rebate['a_limit']) ? $_parent_rebate['a_limit'] : '';
                                $_parent_b_limit = isset($_parent_rebate['b_limit']) ? $_parent_rebate['b_limit'] : '';
                                $_parent_c_limit = isset($_parent_rebate['c_limit']) ? $_parent_rebate['c_limit'] : '';
                                $_parent_bet_limit = isset($_parent_rebate['bet_limit']) ? $_parent_rebate['bet_limit'] : '';
                                $_parent_issue_limit = isset($_parent_rebate['issue_limit']) ? $_parent_rebate['issue_limit'] : '';
                                @endphp
                                <td width="12%" data-rel="{{$option->trait}}-a" data-limit="{{$_parent_a_limit}}">
                                    <input class="inputFocus" isNumber="true" limitCheck="true" maxlength="6" type="text" name="rebate[{{$option->id}}][a_limit]" value="{{$_a_limit}}">
                                </td>
                                <td width="12%" data-rel="{{$option->trait}}-b" data-limit="{{$_parent_b_limit}}">
                                    <input class="inputFocus" isNumber="true" limitCheck="true" maxlength="6" type="text" name="rebate[{{$option->id}}][b_limit]" value="{{$_b_limit}}">
                                </td>
                                <td width="12%" data-rel="{{$option->trait}}-c" data-limit="{{$_parent_c_limit}}">
                                    <input class="inputFocus" isNumber="true" limitCheck="true" maxlength="6" type="text" name="rebate[{{$option->id}}][c_limit]" value="{{$_c_limit}}">
                                </td>
                                <td width="12%" data-rel="{{$option->trait}}-bet" data-limit="{{$_parent_bet_limit}}">
                                    <input class="inputFocus" isNumber="true" limitCheck="true" maxlength="10" type="text" name="rebate[{{$option->id}}][bet_limit]" value="{{$_bet_limit}}">
                                </td>
                                <td width="12%" data-rel="{{$option->trait}}-issue" data-limit="{{$_parent_issue_limit}}">
                                    <input class="inputFocus" isNumber="true" limitCheck="true" maxlength="10" type="text" name="rebate[{{$option->id}}][issue_limit]" value="{{$_issue_limit}}">
                                </td>
                                <td width="5%"></td>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                            @endforeach
                    </td>
                    <td class="Main_right" width="5"></td>
                </tr>
                <tr>
                    <td class="Main_bottom_left"></td>
                    <td background="{{asset('img/merchant/tab_19.gif')}}" align="center">
                        <input type="submit" id="submit" name="submit"  class="input2" value="保存">
                        <input type="button" class="input2" onclick="history.go(-1)" value="取消">
                    </td>
                    <td class="Main_bottom_right"></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection
@section('script')
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
        $.validator.addMethod("limitCheck", function(value, element) {
            var _limit = $(element).parent('td').data('limit');
            return math_sub(_limit, value) >= 0
        }, function (value, element) {
            var _limit = $(element).parent('td').data('limit');
            return "此处数值不得大于"+_limit;
        });
        $(function () {
            $.each($('.tableTrait .traitLine input.inputFocus'),function () {
                var _rel = $(this).data('rel');
                $(this).val($('.tableRebate [data-rel="'+_rel+'"]').find('input.inputFocus').val());
            });
            $('input[data-trait]').click(function () {
                $.each($(this).parent().parent().find('input.inputFocus'),function () {
                    var _rel = $(this).data('rel');
                    $('.tableRebate [data-rel="'+_rel+'"]').find('input.inputFocus').val($(this).val())
                });
            })
            $('#rebate-form').validate({
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
                                    layer.msg(_html.join(),{icon:5})
                                }
                            }
                        }
                    );
                }
            })
        })
    </script>
    @endsection
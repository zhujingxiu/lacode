@extends('merchant.base.main')
@section('content')
    <div id="page-content">
        <form action="{{route('merchant.config-rebate')}}" method="post" id="rebate-form">
            {{csrf_field()}}
            <table border="0" cellspacing="0" cellpadding="0" class="Main">
                <tbody>
                <tr>
                    <td class="Main_top_left"></td>
                    <td class="main_top">
                        <div>
                            <img style="margin-right:5px" src="{{asset('img/merchant/tb.gif')}}" width="16" height="16" alt="">
                            管理員默认退水设置
                            <div style="float: right">
                        <a href="javascript:history.go(-1);" class="font_r F_bold">
                            <img src="/img/merchant/fh.gif">
                            <span color="#FF0000" style="font-weight:bold">返囬</span>
                        </a>
                            </div>
                        </div>
                    </td>
                    <td class="Main_top_right" >

                    </td>
                </tr>
                <tr>
                    <td class="Main_left"></td>
                    <td class="Main_conter">
                        @foreach($games as $game)
                            <div class="rebateGame">{{$game->title}}</div>
                            <table border="0" cellspacing="" cellpadding="0" class="tableRebate">
                                <theade>
                                    <th>交易類型</th>
                                    <th>A盤</th>
                                    <th>B盤</th>
                                    <th>C盤</th>
                                    <th>單註限額</th>
                                    <th>單期限額</th>
                                </theade>
                                <tbody>
                                @foreach($game->rebates as $trait=>$rebate)
                                    <tr class="rebateLine">
                                        <td>{{trait_type($trait)}}</td>
                                        <td>
                                            <input type="text" class="inputFocus" isNumber="true" maxlength="6" name="rebate[{{$game->id}}][{{$trait}}][a_limit]" value="{{$rebate['a_limit']}}">
                                        </td>
                                        <td>
                                            <input type="text" class="inputFocus" isNumber="true" maxlength="6" name="rebate[{{$game->id}}][{{$trait}}][b_limit]" value="{{$rebate['b_limit']}}">
                                        </td>
                                        <td>
                                            <input type="text" class="inputFocus" isNumber="true" maxlength="6" name="rebate[{{$game->id}}][{{$trait}}][c_limit]" value="{{$rebate['c_limit']}}">
                                        </td>
                                        <td>
                                            <input type="text" class="inputFocus" isNumber="true" maxlength="10" name="rebate[{{$game->id}}][{{$trait}}][bet_limit]" value="{{$rebate['bet_limit']}}">
                                        </td>
                                        <td>
                                            <input type="text" class="inputFocus" isNumber="true" maxlength="10" name="rebate[{{$game->id}}][{{$trait}}][issue_limit]" value="{{$rebate['issue_limit']}}">
                                        </td>
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
                <tr>
                    <td class="Main_bottom_left"></td>
                    <td align="center">
                        註：默認退水設置僅供快速設置退水限額；設置前已開的帳戶按原退水不變。
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
        });
    </script>
    @endsection
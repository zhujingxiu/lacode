@extends('merchant.base.main')
@section('content')
    <div id="page-content">
        <form action="{{route('merchant.config-odds')}}" method="post" id="odds-form">
            {{csrf_field()}}
            <table border="0" cellspacing="0" cellpadding="0" class="Main">
                <tbody>
                <tr>
                    <td class="Main_top_left"></td>
                    <td class="main_top">
                        <div>
                            <img style="margin-right:5px" src="{{asset('img/merchant/tb.gif')}}" width="16" height="16" alt="">
                            賠率設置 - <span id="game-title">{{$game->title}}</span>賠率設置
                            <div style="float: right">
                                <a href="javascript:history.go(-1);" class="font_r F_bold">
                                    <img src="/img/merchant/fh.gif">
                                    <span color="#FF0000" style="font-weight:bold">返囬</span>
                                </a>
                                <select id="change-game">
                                    @foreach($games as $item)
                                        <option value="{{$item->id}}" {{$item->id==$game->id ? 'selected':''}}>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </td>
                    <td class="Main_top_right"></td>
                </tr>
                <tr>
                    <td class="Main_left"></td>
                    <td class="Main_conter" id="odds-game">
                        <h3 align="center">加载中，请稍后</h3>
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
                        註：默認賠率表更變不會即時影響正在開盤中的賠率。
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
        function load_odds() {
            var _game = $('#change-game').val();
            var _url = '{{route('merchant.config-odds')}}';
            $.getJSON(_url,{game:_game,_t:Math.random()},function (json) {
                if(json.error_code>0){
                    layer.alert(json.msg, {icon:5});
                }else{
                    if(json.hasOwnProperty('data') && json.data.hasOwnProperty('tpl')){
                        $('#game-title').html(json.data.title);
                        $('#odds-game').html(json.data.tpl);
                    }else{
                        layer.msg(json.msg);
                    }
                }
            });
        }
        $(function () {
            load_odds();
            $('#change-game').change(function () {
                load_odds();
            });
            $('#odds-form').validate({
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
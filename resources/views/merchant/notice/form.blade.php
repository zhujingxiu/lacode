@extends('merchant.base.main')
@section('content')
    <div id="page-content">
        <form action="{{route('merchant.notice-store')}}" method="post" id="notice-form">
            {{csrf_field()}}
            @if(!empty($notice))
                <input type="hidden" name="notice" value="{{$notice->id}}">
                @endif
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
                                        <tbody>
                                        <tr>
                                            <td width="17"><img src="{{asset('img/merchant/tb.gif')}}" width="16" height="16"></td>
                                            <td width="99%"><font style="font-weight:bold" color="#344B50">&nbsp;新增公告</font></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td width="16"><img src="{{asset('img/merchant/tab_07.gif')}}" alt=""></td>
                            </tr>
                            <tr>
                                <td class="t"></td>
                                <td class="c">
                                    <!-- strat -->
                                    <table border="0" cellspacing="0" class="conter tableStriped">
                                        <tbody><tr class="tr_top">
                                            <th colspan="2">基本資料</th>
                                        </tr>
                                        <tr>
                                            <td class="bj1" align="right">公告內容
                                            </td>
                                            <td class="left_p61">
                                                <textarea rows="6" width="100%" height="50%" cols="60" id="Editors" name="content" minlength="8">{{empty($notice) ? '' : ($notice->content)}}</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj1" align="right">會員頁</td>
                                            <td align="left">
                                                &nbsp; <input name="option[]" value="member" type="checkbox" {{empty($notice)?'':($notice->member?'checked':'')}}> 是
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj1" align="right">提示窗</td>
                                            <td align="left">
                                                &nbsp; <input name="option[]" value="modal" type="checkbox" {{empty($notice)?'':($notice->modal?'checked':'')}}> 是
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj1" align="right">代理頁</td>
                                            <td align="left">
                                                &nbsp; <input name="option[]" value="merchant" type="checkbox" {{empty($notice)?'':($notice->merchant?'checked':'')}}> 是
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- end -->
                                </td>
                                <td class="r"></td>
                            </tr>
                            <tr>
                                <td width="12"><img src="{{asset('img/merchant/tab_18.gif')}}" alt=""></td>
                                <td class="f" align="center"><input type="button" class="inputs" onclick="$('#notice-form').submit()" value="確認新增"></td>
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
        </form>
    </div>
    @endsection
@section('script')
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
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
            $('#notice-form').validate({
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
        });
    </script>
    @endsection
@extends('merchant.base.main')
@section('content')
    <div id="page-container">
        <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
            <tbody><tr>
                <td width="5" height="100%" bgcolor="#4F4F4F"></td>
                <td class="c">

                    <table border="0" cellspacing="0" class="main ">
                        <tbody>
                        <tr>
                            <td width="12"><img src="{{asset('img/merchant/tab_03.gif')}}" alt=""></td>
                            <td background="{{asset('img/merchant/tab_05.gif')}}">
                                <form method="post" action="{{route('merchant.user-admin')}}" id="new-admin">
                                    {{csrf_field()}}
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                    <tr>
                                        <td width="16"><img src="{{asset('img/merchant/tb.gif')}}" width="16" height="16"></td>
                                        <td>&nbsp;后台帳號管理</td>
                                        <td><font color="#FF0000">注意：安全码及密码,如不修改密码请保持为空!!!</font></td>
                                        <td align="right">添加管理：&nbsp;
                                            <input type="text" name="name" id="form-name" required maxlength="32" nameCheck="true">&nbsp;
                                            <input type="submit" class="inputs" value="添加" >
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </form>
                            </td>
                            <td width="16"><img src="{{asset('img/merchant/tab_07.gif')}}" alt=""></td>
                        </tr>
                        <tr>
                            <td class="t"></td>
                            <td class="c">
                                <!-- strat -->
                                <table border="0" cellspacing="0" class="conter tableStriped">
                                    <tbody>
                                    <tr class="tr_top">
                                        <td width="30">在綫</td>
                                        <td>帳號</td>
                                        <td>名稱</td>
                                        <td>密码</td>
                                        <td>安全码</td>
                                        <td>活动时间</td>
                                        <td>功能狀態</td>
                                        <td width="150">操作</td>
                                    </tr>
                                    @forelse($admins as $admin)
                                    <tr>
                                        <td width="30" align="center">
                                            @if($admin->online)
                                                <img src="{{asset('img/merchant/user_1.gif')}}">
                                                @else
                                                <img src="{{asset('img/merchant/user_0.gif')}}">
                                            @endif
                                        </td>
                                        <td align="center">
                                            <font color="red"><b>{{$admin->name}}</b></font>
                                        </td>
                                        <td align="center"><input type="text" name="nick_name" value="{{$admin->nick_name}}" size="8" class="inputstyle"></td>
                                        <td align="center"><input type="password" name="pwd" value="" size="8" class="inputstyle"></td>
                                        <td align="center"><input type="password" name="code" value="" size="8" class="inputstyle"></td>
                                        <td align="center">{{$admin->created_at}}</td>
                                        <td align="center">
                                            公告:<input checked="checked"  type="checkbox" name="ggg" value="1">
                                            必中/不中:<input checked="checked"  type="checkbox" name="gauto" value="1">
                                            &nbsp; &nbsp;
                                            修改注单/删除：<input checked="checked"  type="checkbox" name="ggd" value="1">
                                            &nbsp;&nbsp;
                                            注单校验/被删：<input checked="checked"  type="checkbox" name="gzhud" value="1">
                                            &nbsp;&nbsp;
                                            超级用户：<input checked="checked"  type="checkbox" name="gcj" value="1">
                                        </td>
                                        <td align="center">
                                            <input type="hidden" name="guid" value="264">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                <tr>
                                                    <td class="nones" width="15"><img src="{{asset('img/merchant/edit.gif')}}"></td>
                                                    <td class="nones" width="30"><input type="submit" value="修改"></td>
                                                    <td class="nones" width="16"><img src="{{asset('img/merchant/55.gif')}}"></td>
                                                    <td class="nones" width="30"><a href="LoginLog.php?uid=administrator1">日誌</a></td>
                                                    <td class="nones" width="16"><img src="{{asset('img/merchant/44.gif')}}"></td>
                                                    <td class="nones" width="26"><a href="javascript:void(0)" onclick="deluser('264')">刪除</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                        @empty
                                    <tr><td colspan="8">当前没有记录</td></tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <!-- end -->
                            </td>
                            <td class="r"></td>
                        </tr>
                        <tr>
                            <td width="12"><img src="{{asset('img/merchant/tab_18.gif')}}" alt=""></td>
                            <td class="f" align="right"></td>
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
                    layer.tips(error.text(), element,{tips: 1});
            }
        });
        $.validator.addMethod("nameCheck", function(value, element) {
            $.ajaxSettings.async = false;
            var ret = false;
            $.getJSON("{{route('merchant.user-check')}}",{id:0,name:$('#form-name').val(),_t:Math.random()},function (json) {

                return ret = json.error_code==0;
            });
            return ret;
            $.ajaxSettings.async = true;
        }, "賬戶已在使用中");
        $(function () {
            $('#new-admin').validate({
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
            })
        })
    </script>
@endsection
@extends('merchant.base.main')
@section('content')
    <div id="page-container">
        <form method="post" action="{{route('merchant.user-store')}}" id="user-form">
            {{csrf_field()}}
            <input type="hidden" name="code" value="{{$role->code}}">
            <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
                <tbody>
                <tr>
                    <td width="5" height="100%" bgcolor="#4F4F4F"></td>
                    <td class="c">
                        <table border="0" cellspacing="0" class="main">
                            <tbody>
                            <tr>
                                <td width="12"><img src="/img/merchant/tab_03.gif" alt=""></td>
                                <td background="/img/merchant/tab_05.gif">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td width="17"><img src="/img/merchant/tb.gif" width="16" height="16"></td>
                                            <td width="96%"><font style="font-weight:bold" color="#344B50">&nbsp;{{$role->title}}-&gt;新增</font></td>
                                            <td width="35" align="left">
                                                <a href="javascript:history.go(-1);" class="font_r F_bold">
                                                    <img src="/img/merchant/fh.gif">
                                                    <span color="#FF0000" style="font-weight:bold">返囬</span>
                                                </a>
                                            </td>
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
                                    <table border="0" cellspacing="0" class="conter tableCreate">
                                        <tbody>
                                        <tr class="tr_top">
                                            <th colspan="6">帳戶資料</th>
                                        </tr>
                                        @if($parent_role && $parent_role->id)
                                            <tr>
                                                <td class="bj">上級{{$parent_role->title}}帳號</td>
                                                <td class="left_p5 inputOnMouse">
                                                    <select name="parent_id" id="parent_id" class="linkageMerchant">
                                                    </select>
                                                    <span class="formTips">上級餘額：<b id="merchant-balance"></b></span>
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="bj">{{$role->title}}帳號</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input name="name" type="text" autocomplete="false" class="inp1MM" id="form-name">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">{{$role->title}}名稱</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input id="form-nick" class="inp1MM" type="text" name="nick_name" autocomplete="false" >
                                            </td>
                                        </tr>
                                        <tr>

                                            <td class="bj">新密碼</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input id="form-pwd" class="inp1MM" type="password" name="password" autocomplete="false">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">信用額度</td>
                                            <td class="left_p5 inputOnMouse toUpcase">
                                                <input id="form-credit" class="inp1MM" type="text" name="credit"  value="0" >
                                                <b id="rmb" class="red showUpcase"></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">{{$rate_remain ? $parent_role->title: $role->title}}占成</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input id="form-rate" class="inp1MM" type="text" name="rate" value="0" >%
                                                <span class="formTips"><b id="merchant-rate" style="display: none"></b></span>
                                            </td>
                                        </tr>
                                        @if($rate_remain)
                                        <tr style="height:28px">
                                            <td class="bj">{{$role->title}}占成</td>
                                            <td class="left_p5">
                                                <br>
                                                <input type="radio" value="1" checked="checked" name="rate_remain" id="rate-remain-any">占余成数下线任占
                                                <br>
                                                <input type="radio" value="0" name="rate_remain" id="rate-remain-num">限制下线可占成数
                                                <input style="width:35px;" class="inp1MM" type="text" name="rate_self" value="0" maxlength="3">
                                                %
                                            </td>
                                        </tr>

                                        @endif
                                        @if($order_now)
                                            <tr>
                                                <td class="bj">即時註單</td>
                                                <td class="left_p5">
                                                    <input type="radio" value="1" id="form-order-1" name="order_now" checked="checked">啓用
                                                    <input type="radio" value="0" id="form-order-0" name="order_now">禁用
                                                </td>
                                            </tr>
                                        @endif
                                        @if($replenish)
                                            <tr>
                                                <td class="bj">補貨功能</td>
                                                <td class="left_p5">
                                                    <input type="radio" value="1" id="form-replenish1" name="replenish" checked="checked">啓用
                                                    <input type="radio" value="0" id="form-replenish0" name="replenish">禁用
                                                </td>
                                            </tr>
                                        @endif
                                        @if($rate_company)
                                        <tr>
                                            <td class="bj">占余成数归</td>
                                            <td class="left_p5">
                                                <input type="radio" value="1" id="form-rate-company-1" name="rate_company" checked="checked">总公司
                                                <input type="radio" value="0" id="form-rate-company-0" name="rate_company">分公司
                                            </td>
                                        </tr>
                                        @endif
                                        @if($charges)
                                        <tr>
                                            <td class="bj">赚佣</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input  class="inp1MM" type="text" name="charges" id="form-charges" value="0" >&nbsp;
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="bj">狀態</td>
                                            <td class="left_p5">
                                                <input id="form-status-1" name="status" type="radio" value="1" checked="checked">啟用&nbsp;
                                                <input id="form-status--1" name="status" type="radio" value="-1">凍結&nbsp;
                                                <input id="form-status-0" name="status" type="radio" value="0">停用&nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- end -->
                                </td>
                                <td class="r"></td>
                            </tr>
                            <tr>
                                <td width="12"><img src="/img/merchant/tab_18.gif" alt=""></td>
                                <td class="f" align="center">
                                    <input type="submit" class="inputs" value="確認新增">
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
            $('#user-form').validate({
                rules : {
                    name:{
                        required: true,
                        minlength: 4,
                        maxlength: 32,
                        nameCheck: true
                    },
                    nick_name:{
                        required: true,
                        minlength: 2,
                        maxlength: 32
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 32
                    },
                    credit: {
                        required: true,
                        isNumber: true,
                        minFloat: 0
                    },
                    rate:{
                        isNumber: true,
                        minFloat: 0,
                        maxFloat: 100.00
                    },
                    charges: {
                        isNumber: true,
                        minFloat: 0,
                        maxFloat: 100.00
                    }

                },
                messages : {
                    name:{
                        required: '賬戶必須填寫',
                        minlength: '賬戶最小長度為4',
                        maxlength: '賬戶最大長度為32',
                    },
                    nick_name:{
                        required: '賬戶名稱必須填寫',
                        minlength: '賬戶名稱最小長度為2',
                        maxlength: '賬戶名稱最大長度為32'
                    },
                    password: {
                        required: '賬戶密碼必須填寫',
                        minlength: '賬戶密碼最小長度為6',
                        maxlength: '賬戶密碼最大長度為32'
                    },
                    credit: {
                        required: '賬戶信用額度必須添加',
                        isNumber: '賬戶信用額度必須是數字',
                        minFloat: '賬戶信用額度的最小值不小於0'
                    },
                    rate:{
                        isNumber: '賬戶佔成必須是數字',
                        minFloat: '賬戶佔成最小值不小於0'
                    },
                    charges: {
                        isNumber: '賬戶賺佣必須是數字',
                        minFloat: '賬戶賺佣最小值不小於0'
                    }
                },
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
            @if($parent_role && $parent_role->id)
                role_merchants('{{$parent_role->id}}');
                $('.linkageMerchant').change(function () {
                    var that = $(this);
                    that.next('#merchant-balance > b').text('加載中...');
                    $('#merchant-rate > b').empty().hide();
                    var _merchant_id = that.val();
                    $.getJSON('{{route('merchant.user-merchant')}}',{merchant:_merchant_id,_t:Math.random()},function (json) {
                        if (json.error_code > 0) {
                            layer.alert(json.msg, {icon: 5});
                            return false;
                        }else {
                            var _merchant = json.data.merchant;
                            var _balance = _merchant.info.balance;
                            var _rate = _merchant.info.rate;
                            $('#merchant-balance').text(_balance);

                            $('input[name="credit"]').rules('add',{maxFloat:_balance});
                            $('input[name="rate"]').rules('add',{maxFloat:_rate});
                            $('#merchant-rate').html('最高占成'+_rate+'%').show()
                        }
                    })
                });
                $('input[name="charges"]').rules('remove');
            $('.linkageMerchant').trigger('change');
            @endif
        });

        function role_merchants(role_id) {
            $.ajaxSettings.async = false;
            $.getJSON('{{route('merchant.user-merchants')}}', {role:role_id, _t: Math.random()}, function (json) {
                if (json.error_code > 0) {
                    layer.alert(json.msg, {icon: 5});
                    return false;
                }else {
                    var _merchants = json.data.merchants;
                    var _html = '';
                    for (i in _merchants) {
                        _html += '<option value="' + _merchants[i].id + '">' + _merchants[i].name + '</opion>';
                    }
                    $('select[name="parent_id"]').html(_html);
                }
            });
            $.ajaxSettings.async = true;
        }
    </script>
    @endsection
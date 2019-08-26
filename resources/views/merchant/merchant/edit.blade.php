@extends('merchant.base.main')
@section('content')
    <div id="page-container">
        <form method="post" action="{{route('merchant.user-edit',$merchant)}}" id="user-form">
            {{csrf_field()}}
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
                                            <td width="96%"><font style="font-weight:bold" color="#344B50">用户信息 {{$merchant->name}}【{{$merchant->role->title}}】</font></td>
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
                                        <tr>
                                            <td class="bj">{{$merchant->role->title}}帳號</td>
                                            <td class="left_p5 inputOnMouse">{{$merchant->name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">{{$merchant->role->title}}名稱</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input id="form-nick" class="inp1MM" type="text" name="nick_name" value="{{$merchant->nick_name}}" >
                                            </td>
                                        </tr>
                                        <tr>

                                            <td class="bj">新密碼</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input id="form-pwd" class="inp1MM" type="password" name="password" >
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">信用額度</td>
                                            <td class="left_p5 inputOnMouse toUpcase">
                                                <input id="form-credit" class="inp1MM" type="text" name="credit"  value="{{$merchant->info->credit}}" >
                                                <b id="rmb" class="red showUpcase"></b>
                                                <font color="344b50">『 可‘回收’餘額 {{$merchant->info->balance}}』</font>
                                                @if($parent_role)
                                                <font color="344b50">『 上级{{$merchant->parent->role->title}} {{$merchant->parent->name}} 可用餘額 {{$merchant->parent->info->balance}}』</font>
                                                    @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">{{$merchant->role->title}}占成</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input id="form-rate" class="inp1MM" type="text" name="rate" value="{{$merchant->info->rate}}" >%
                                                @if($parent_role)
                                                    <span class="formTips">最高可設占成：<b id="merchant-rate">{{$merchant->parent->info->rate}}%</b></span>
                                                    @else
                                                    <span class="formTips"><b id="merchant-rate" style="display: none"></b></span>
                                                    @endif
                                            </td>
                                        </tr>
                                        @if($parent_role)
                                        <tr style="height:28px">
                                            <td class="bj">上级{{$merchant->parent->role->title}}占成</td>
                                            <td class="left_p5">
                                                {{$merchant->info->rate_limit}}%

                                            </td>
                                        </tr>

                                        @endif
                                        @if($order_now)
                                            <tr>
                                                <td class="bj">即時註單</td>
                                                <td class="left_p5">
                                                    <input type="radio" value="1" id="form-order-1" name="order_now" {{$merchant->info->order_now ? 'checked="checked"' :''}}>啓用
                                                    <input type="radio" value="0" id="form-order-0" name="order_now" {{!$merchant->info->order_now ? 'checked="checked"' :''}}>禁用
                                                </td>
                                            </tr>
                                        @endif
                                        @if($replenish)
                                            <tr>
                                                <td class="bj">補貨功能</td>
                                                <td class="left_p5">
                                                    <input type="radio" value="1" id="form-replenish1" name="replenish" {{$merchant->info->replenish ? 'checked="checked"' :''}}>啓用
                                                    <input type="radio" value="0" id="form-replenish0" name="replenish" {{!$merchant->info->replenish ? 'checked="checked"' :''}}>禁用
                                                </td>
                                            </tr>
                                        @endif
                                        @if($rate_company)
                                        <tr>
                                            <td class="bj">总公司占成</td>
                                            <td class="left_p5">
                                                {{bcsub(100,$merchant->info->rate,2)}}%
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">占余成数归</td>
                                            <td class="left_p5">
                                                {{$merchant->info->rate_company ? '总公司' :'分公司'}}
                                            </td>
                                        </tr>
                                        @endif
                                        @if($charges)
                                        <tr>
                                            <td class="bj">赚佣</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input  class="inp1MM" type="text" name="charges" id="form-charges" value="{{$merchant->info->charges}}" >&nbsp;
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="bj">狀態</td>
                                            <td class="left_p5">
                                                <input id="form-status-1" name="status" type="radio" value="1" {{$merchant->status>=1 ? 'checked="checked"' :''}}>啟用&nbsp;
                                                <input id="form-status--1" name="status" type="radio" value="-1" {{$merchant->status==-1 ? 'checked="checked"' :''}}>凍結&nbsp;
                                                <input id="form-status-0" name="status" type="radio" value="0" {{$merchant->status==0 ? 'checked="checked"' :''}}>停用&nbsp;
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
                                    <input type="submit" class="inputs" value="確認更改">
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

        $(function () {
            $('#form-credit').trigger('keyup');
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
                        minFloat: 0,
                        @if($parent_role)
                        maxFloat: parseFloat('{{bcadd($merchant->parent->info->balance,$merchant->info->credit,2)}}').toFixed(2)
                        @endif
                    },
                    rate:{
                        isNumber: true,
                        minFloat: 0,
                        @if($parent_role)
                        maxFloat: '{{$merchant->parent->info->rate}}'
                        @endif
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
        });


    </script>
    @endsection
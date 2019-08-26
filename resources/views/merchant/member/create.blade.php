@extends('merchant.base.main')

@section('content')
    <div id="page-content">
        <form method="post" action="{{route('merchant.member-store')}}" id="member-form">
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
                                            <td width="17">
                                                <img src="/img/merchant/tb.gif" width="16" height="16">
                                            </td>
                                            <td width="96%">
                                                <font style="font-weight:bold" color="#344B50">會員 &nbsp;-&gt;新增{{$code!='proxy' ? '直属会员' :''}}</font>
                                            </td>
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
                                            <th colspan="2"><b>帳戶資料</b></th>
                                        </tr>
                                        @if($code!='proxy')
                                            <tr>
                                                <td class="bj" id="bj">上級直屬</td>
                                                <td class="left_p5" id="change-role">
                                                    <input type="radio" name="code" value="company" {{$code=='company'?'checked':''}}>分公司
                                                    <input type="radio" name="code" value="shareholder" {{$code=='shareholder'?'checked':''}}>股東
                                                    <input type="radio" name="code" value="agent" {{$code=='agent'?'checked':''}}>總代理
                                                </td>
                                            </tr>
                                            @else
                                            <tr style="display: none">
                                                <td class="bj" id="bj">上級直屬</td>
                                                <td class="left_p5" id="pc">
                                                    <input type="radio" name="code" value="proxy" checked>代理
                                                </td>
                                            </tr>
                                            @endif
                                        <tr>
                                            <td class="bj" id="bj">上級{{$code=='proxy'?'代理':'帳號'}}</td>
                                            <td class="left_p5" style="color:#0000FF">
                                                <select name="merchant_id" id="merchants" class="linkageMerchant">
                                                </select>
                                                <span class="formTips">上級餘額：<b id="merchant-balance">0</b></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">會員帳號</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input type="text" class="inp1MM" name="name" id="form-name" >
                                                <span id="s_name1"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">登陸密碼</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input class="inp1MM" name="password" id="form-pwd" type="password">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">會員名稱</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input class="inp1MM" name="nick_name" id="form-nick" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">信用額度</td>
                                            <td class="left_p5 inputOnMouse toUpcase">
                                                <input class="inp1MM" name="credit" id="form-credit" type="text">
                                                <b id="rmb" class="red showUpcase"></b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj" id="zj">代理占成</td>
                                            <td class="left_p5 inputOnMouse">
                                                <input id="form-rate" class="inp1MM" type="text" name="rate" value="0" >%
                                                <span class="formTips"><b id="merchant-rate" style="display: none"></b></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">開放盤口</td>
                                            <td class="left_p5">
                                                <input type="radio" value="a" name="roulette" checked="checked" >A盤
                                                <input type="radio" value="b" name="roulette"> B盤
                                                <input type="radio" value="c" name="roulette"> C盤
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="bj">退水設定</td>
                                            <td class="left_p5">
                                                <select name="rebate" id="form-rebate" class="blueOptions">
                                                    <option selected="selected" value="0" >水全退到底 </option>
                                                    <option value="0.3" >賺取0.3退水</option>
                                                    <option value="0.5" >賺取0.5退水</option>
                                                    <option value="1" >賺取1.0退水</option>
                                                    <option value="2" >賺取2.0退水</option>
                                                    <option value="2.5" >賺取2.5退水</option>
                                                    <option value="100" >賺取所有退水</option>
                                                </select>
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
                                    <input type="submit" class="inputs" value="確 定">&nbsp;&nbsp;
                                    <input type="button" class="inputs" onclick="closesPop()" value="取消"></td>
                                <td width="16"><img src="/img/merchant/tab_20.gif" alt=""></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td width="5" bgcolor="#4F4F4F"></td>

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
            $.getJSON("{{route('merchant.member-check')}}",{id:0,name:$('#form-name').val(),_t:Math.random()},function (json) {

                return ret = json.error_code==0;
            });
            return ret;
            $.ajaxSettings.async = true;
        }, "賬戶已在使用中");
        function load_role_merchants() {
            $.ajaxSettings.async = false;
            var _url = '{{route('merchant.member-merchants')}}';
            var _role = $('input[name="code"]:checked').val();
            console.log(_role)
            $.getJSON(_url,{role:_role,_t:Math.random()},function (json) {
                if(json.error_code>0){
                    layer.alert('加载代理出错',{icon:5});
                    return false;
                }
                var _html = '';
                for( i in json.data.merchants){
                    var _merchant = json.data.merchants[i];
                    _html += '<option data-balance="'+_merchant.info.balance+'" value="'+_merchant.id+'">'+_merchant.name+'</option>';
                }
                _html +='';
                $('#merchants').html(_html);
            });
            $.ajaxSettings.async = true;
        }
        $(function () {
            load_role_merchants();

            $('.linkageMerchant').change(function () {
                var that = $(this);
                that.next('#merchant-balance > b').text('加載中...');
                $('#merchant-rate > b').empty().hide();
                var _merchant_id = $(this).val();
                $.getJSON('{{route('merchant.member-merchant')}}',{merchant:_merchant_id,_t:Math.random()},function (json) {
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
            $('.linkageMerchant option:first').trigger('change');
            $('#change-role').click(function () {
                console.log($('input[name="code"]:checked').val());
                load_role_merchants();
                $('.linkageMerchant option:first').trigger('change');
            });
            $('#member-form').validate({
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
                },
                messages : {
                    name:{
                        required: '賬戶必須填寫',
                        minlength: '賬戶最小長度為4',
                        maxlength: '賬戶最大長度為32'
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
                                    layer.msg(_html.join(),{icon:5})
                                }
                            }
                        }
                    );
                }
            });
        })

    </script>
@endsection
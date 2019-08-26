<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OA后台管理</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--jQuery [ REQUIRED ]-->
    <script src="/js/jquery.min.js"></script>

</head>

<body>
<form action="{{route('merchant.login')}}" method="post" id="login-form" onsubmit="return finalcheck();">
    {{ csrf_field() }}
    <div class="box">
        <div class="top"></div>
        <div class="boxBg clearfix">
            <ul>
                <li><input type="text" id="loginName" name="name" class="btn"/></li>
                <li><input type="password" id="loginPwd" name="password" class="btn"/></li>
                <li><input type="text" id="captcha" name="captcha" maxlength="5" autocomplete="off"  class="w100 btn"/>
                    <span class="code" id="code">
                        <img id="captchaImg" align="bottom" src="{{captcha_src('flat')}}"  onclick="this.src='{{captcha_src('flat')}}'+Math.random()">
                    </span>
                </li>
            </ul>
        </div>
        <div class="bottom clearfix">
            <input name="smt" value="" type="submit" class="btn submit-btn"/>
            <div class="error-help">
                @if(count($errors))
                    @php
                    $error_items = json_decode($errors,TRUE);
                    @endphp
                    @if(is_array($error_items) && count($error_items))
                        {{implode(",",current($error_items))}}
                    @endif
                    @endif
            </div>
        </div>

    </div>
</form>
<script>
    function finalcheck() {
        if ($.trim($("#loginName").val()) == "") {
            $('.error-help').html('請填寫帳號');
            $("#loginName").focus();
            return false;
        }
        if ($.trim($("#loginPwd").val()) == "") {
            $('.error-help').html('請填寫密碼');
            $("#loginPwd").focus();
            return false;
        }
        if ($.trim($("#captcha").val()) == "") {
            $('.error-help').html('請填寫安全碼');
            $("#captcha").focus();
            return false;
        }
        return true;
    }

    function digitOnly(evt) {
        var code = (evt.keyCode ? evt.keyCode : evt.which);  //兼容火狐 IE

        if (!(code >= 48 && code <= 57 || code == 45)) {
            evt.keyCode = "";
        }
    }

    $(document).ready(function () {
        $(document).keydown(function(event){
            if (event.keyCode == 13) {
                $(this).submit();
            }
        });
    });
</script>
<style>
    body {
        margin: 0px;
        overflow: hidden;
        background: url(/img/merchant/login/bg.jpg);
        height: 100%;
    }

    img {
        border: none;
    }

    a {
        blur: expression(this.onFocus=this.blur());
        border: none;
    }

    a:focus {
        outline: 0;
    }

    input:focus {
        outline: 0;
    }

    input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 200px #fff inset;
        color: #333;
    }

    .clearfix {
        clear: both;
    }

    .line {
        width: 100%;
        height: 5px;
        background: #162400;
        border-bottom: 1px solid #9bbf1f;
        padding: 0;
        margin: 0;
        float: left;
    }

    .box {
        width: 490px;
        margin: 0 auto;
    }

    .box .top {
        width: 490px;
        height: 253px;
        float: left;
        background: url(/img/merchant/login/login_top.jpg) no-repeat;
    }

    .box .boxBg {
        width: 317px;
        padding-left: 173px;
        height: 164px;
        float: left;
        background: url(/img/merchant/login/login_box.jpg) no-repeat;
        position: relative;
    }

    .box .boxBg ul {
        width: 317px;
        float: left;
        padding: 0;
        margin: 0;
    }

    .box .boxBg li {
        width: 205px;
        height: 30px;
        margin-top: 14px;
        float: left;
        display: inline;
        padding: 0;
    }

    .box .boxBg span {
        width: 100px;
        height: 32px;
        float: left;
        position: absolute;
        top: 101px;
        right: 106px;
        z-index: 999;
    }

    .box .boxBg .btn {
        width: 205px;
        height: 28px;
        line-height: 28px;
        border: 0 none;
        float: left;
        font-size: 16px;
        font-weight: bold;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #333;
        background: none;
    }

    .box .boxBg .w100 {
        width: 105px;
    }

    .box .bottom {
        width: 490px;
        height: 178px;
        float: left;
        background: url(/img/merchant/login/login_bottom.jpg) no-repeat;
        text-align: center;
    }

    .box .bottom .btn, .box .bottom .btn_m, .box .bottom .btn_o {
        width: 282px;
        height: 37px;
        background: url(/img/merchant/login/login_btn.jpg) no-repeat;
        border: 0 none;
        cursor: pointer;
    }

    .box .bottom .btn {
        background-position: 0 0;
    }

    .box .bottom .btn_m {
        background-position: 0 -37px;
    }

    .box .bottom .btn_o {
        background-position: 0 -74px;
    }

    .code {
        TEXT-ALIGN: center;
        LINE-HEIGHT: 27px;
        WIDTH: 102px;
        DISPLAY: block;
        FONT-FAMILY: Verdana, 宋体, fantasy;
        LETTER-SPACING: 8px;
        HEIGHT: 29px;
        COLOR: #d7da89;
        FONT-SIZE: 22px;
        cursor: default
    }

    .code img {
        width: 100px;
        height: 32px;
        float: right;
    }
    .error-help{
        color: red;
    }
</style>
</body>
</html>

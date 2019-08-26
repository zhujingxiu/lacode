<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>用户登录</title>

    <script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <script Language="JavaScript">
        function finalcheck() {
            if ($.trim($("#loginName").val()) == "") {
                $('.error-help').html('請填寫“帳號”！');
                $("#loginName").focus();
                return false;
            }
            if ($.trim($("#loginPwd").val()) == "") {
                $('.error-help').html('請填寫“密碼”！');
                $("#loginPwd").focus();
                return false;
            }
            if ($.trim($("#captcha").val()) == "") {
                $('.error-help').html('請填寫“安全碼”！');
                $("#captcha").focus();
                return false;
            }
            //$("#Submit").attr("disabled", true); //启用不可用
            $("#form_login").submit();
            return false;
        }

        function digitOnly(evt) {
            var code = (evt.keyCode ? evt.keyCode : evt.which);  //兼容火狐 IE

            if (!(code >= 48 && code <= 57 || code == 45)) {
                evt.keyCode = "";
            }
        }
    </script>

</head>
<body>
<form id="form_login" action="{{route('member.login')}}" method="post" name="form_login"
      onsubmit="return finalcheck();">
    {{ csrf_field() }}
    <div class="line">
        <div class="clear"></div>
    </div>
    <div class="box">
        <div class="top"></div>
        <div class="boxBg" id="Top_all">
            <ul>
                <li><input type="text" id="loginName" name="username" class="text"/></li>
                <li><input type="password" id="loginPwd" name="pwd" class="text"/></li>
                <li><input type="text" id="captcha" name="captcha" autocomplete="off" maxlength="5" class="w100 text"/>
                    &nbsp;
                    <span id="code" class="code">
                        <img id="ValidateImage" align="bottom" src="{{captcha_src('flat')}}"
                             onclick="this.src='{{captcha_src('flat')}}'+Math.random()">
                    </span>
                </li>
            </ul>
            <div class="clear"></div>
        </div>
        <div class="bottom">
            <input id="Submit" value="" name="Submit" type="submit" class="btn" onMouseOut="this.className='btn'"
                   onMouseOver="this.className='btn_m'"/>
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
        <div class="clear"></div>
    </div>
</form>
<style>


    /*登录*/
    body {
        background: url(/img/member/_bg.jpg);
        margin: 0 auto;
    }

    img {
        border: none;
    }

    a {
        blr: expression(this.onFocus=this.blur());
        border: none;
    }

    a:focus {
        outline: 0;
    }

    input:focus {
        outline: 0;
    }

    input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 200px #341509 inset;
        color: #fff3df;
    }

    .clear {
        clear: both;
    }

    .line {
        width: 100%;
        height: 5px;
        background: #000;
        border-bottom: 1px solid #240e0a;
        padding: 0;
        margin: 0;
    }

    .box {
        width: 873px;
        margin: 3% auto 0 auto;
    }

    .box .top {
        width: 873px;
        height: 222px;
        float: left;
        background: url(/img/member/_loginTop.jpg) no-repeat;
    }

    .box .boxBg {
        width: 413px;
        padding-left: 460px;
        height: 136px;
        float: left;
        background: url(/img/member/_loginbox.jpg) no-repeat;
        position: relative;
    }

    .box .boxBg ul {
        width: 200px;
        float: left;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .box .boxBg li {
        width: 205px;
        margin-top: 12px;
        float: left;
        display: inline;
        padding: 0;
    }

    .box .boxBg span {
        height: 32px;
        float: left;
        position: absolute;
        top: 91px;
        right: 207px;
        z-index: 999;
    }

    .box .boxBg .text {
        width: 200px;
        height: 26px;
        line-height: 26px;
        border: 0 none;
        float: left;
        font-size: 16px;
        font-weight: bold;
        font-family: Verdana, Arial, Helvetica, sans-serif;
        color: #fff3df;
        background: #341509;
    }

    .box .boxBg .w100 {
        width: 125px;
    }

    .box .bottom {
        width: 417px;
        padding-left: 456px;
        height: 319px;
        float: left;
        background: url(/img/member/_loginBottom.jpg) no-repeat;
    }

    .box .bottom .btn, .box .bottom .btn_m, .box .bottom .btn_o {
        width: 120px;
        height: 37px;
        background: url(/img/member/_login_btn.jpg) no-repeat;
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

    /*用户协议*/
    .xyBox {
        width: 650px;
        margin: 3% auto 0 auto;
    }

    .xyBox .top {
        width: 650px;
        height: 111px;
        float: left;
        background: url(/img/member/_xtTop.jpg) no-repeat;
    }

    .xyBox .box1 {
        width: 500px;
        height: 475px;
        padding: 0 75px;
        float: left;
        background: url(/img/member/_xtBox.jpg) no-repeat;
    }

    .xyBox .box1 ul {
        width: 500px;
        float: left;
        padding: 0;
        margin: 0;
    }

    .xyBox .box1 li {
        width: 500px;
        line-height: 18px;
        margin-bottom: 7px;
        float: left;
        color: #eec0a9;
        list-style: none;
        font-size: 12px;
    }

    .xyBox .box1 span {
        width: 20px;
        float: left;
    }

    .xyBox .box1 label {
        width: 480px;
        float: left;
    }

    .xyBox .bottom {
        width: 650px;
        height: 147px;
        float: left;
        background: url(/img/member/_xtBottom.jpg) no-repeat;
        text-align: center;
    }

    .xyBox .bottom .btn, .xyBox .bottom .btn_m, .xyBox .bottom .btn1, .xyBox .bottom .btn_m1 {
        width: 102px;
        height: 36px;
        background: url(/img/member/_xy_btn.jpg) no-repeat;
        border: 0 none;
        cursor: pointer;
    }

    .xyBox .bottom .btn {
        background-position: 0 0;
    }

    .xyBox .bottom .btn_m {
        background-position: 0 -36px;
    }

    .xyBox .bottom .btn1 {
        background-position: -102px 0;
    }

    .xyBox .bottom .btn_m1 {
        background-position: -102px -36px;
    }

    .error-help {
        color: red;
    }

    .code {
        TEXT-ALIGN: center;
        LINE-HEIGHT: 27px;
        WIDTH: 90px;
        FONT-FAMILY: Verdana, 宋体, fantasy;
        LETTER-SPACING: 8px;
        HEIGHT: 29px;
        COLOR: #d7da89;
        FONT-SIZE: 22px;
        cursor: default;
    }

    .code img {
        height: 26px;
    }
</style>
</body>
</html>
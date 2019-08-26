<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录页 | OA后台管理</title>


    <!--STYLESHEET-->
    <!--=================================================-->

    <!--Open Sans Font [ OPTIONAL ]-->
    <link href='https://fonts.loli.net/css?family=Open+Sans' rel='stylesheet'>


    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="{{asset('themes/nifty/css/bootstrap.min.css')}}" rel="stylesheet">


    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="{{asset('themes/nifty/css/nifty.min.css')}}" rel="stylesheet">


    <!--Nifty Premium Icon [ DEMONSTRATION ]-->
    <link href="{{asset('themes/nifty/css/demo/nifty-demo-icons.min.css')}}" rel="stylesheet">

    <!--Demo [ DEMONSTRATION ]-->
    <link href="{{asset('themes/nifty/css/demo/nifty-demo.min.css')}}" rel="stylesheet">

    <!--Ion Icons [ OPTIONAL ]-->
    <link href="{{asset('themes/nifty/plugins/ionicons/css/ionicons.min.css')}}" rel="stylesheet">

    <!--Magic Checkbox [ OPTIONAL ]-->
    <link href="{{asset('themes/nifty/plugins/magic-check/css/magic-check.min.css')}}" rel="stylesheet">
    <link href="{{asset('themes/nifty/plugins/pace/pace.min.css')}}" rel="stylesheet">
    <!--JAVASCRIPT-->
    <!--=================================================-->

    <!--jQuery [ REQUIRED ]-->
    <script src="{{mix('js/jquery.min.js')}}"></script>

    <!--Pace - Page Load Progress Par [OPTIONAL]-->

    <script src="{{asset('themes/nifty/plugins/pace/pace.min.js')}}"></script>

    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="{{asset('themes/nifty/js/bootstrap.min.js')}}"></script>


    <!--NiftyJS [ RECOMMENDED ]-->
    <script src="{{asset('themes/nifty/js/nifty.min.js')}}"></script>

</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
<div id="container" class="cls-container">

    <!-- BACKGROUND IMAGE -->
    <!--===================================================-->
    <div id="bg-overlay"></div>


    <!-- LOGIN FORM -->
    <!--===================================================-->
    <div class="cls-content">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                <div class="mar-ver pad-btm">
                    <h1 class="h3">OA后台管理</h1>
                </div>
                <form action="{{route('admin.login')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="用户名" autofocus name="name">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="密码" name="password">
                    </div>
                    <div class="checkbox pad-btm text-left hidden">
                        <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember">
                        <label for="demo-form-checkbox">Remember me</label>
                    </div>
                    <button class="btn btn-primary btn-lg btn-block" type="submit">登录</button>

                </form>
            </div>

        </div>
    </div>
    <!--===================================================-->
</div>
<!--===================================================-->
<!-- END OF CONTAINER -->


</body>
</html>

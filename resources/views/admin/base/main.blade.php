<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$page_title}} | OA后台管理</title>


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

    <!--JAVASCRIPT-->
    <!--=================================================-->

    <!--jQuery [ REQUIRED ]-->
    <script src="{{asset('js/jquery.min.js')}}"></script>

    <!--Pace - Page Load Progress Par [OPTIONAL]-->
    <link href="{{asset('themes/nifty/plugins/pace/pace.min.css')}}" rel="stylesheet">
    <script src="{{asset('themes/nifty/plugins/pace/pace.min.js')}}"></script>

    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="{{asset('themes/nifty/js/bootstrap.min.js')}}"></script>


    <!--NiftyJS [ RECOMMENDED ]-->
    <script src="{{asset('themes/nifty/js/nifty.min.js')}}"></script>
    <!--Layer-->
    <link href="{{asset('plugins/layer/skin/layer.css')}}" rel="stylesheet">
    <script src="{{asset('plugins/layer/layer.js')}}"></script>
    <script src="{{mix('js/admin.all.js')}}"></script>
    <!--=================================================-->

</head>

<body>
<div id="container" class="effect aside-float aside-bright mainnav-lg">

    <!-- HEADER -->
    @include("admin.base.header")
    <!-- END HEADER -->

    <div class="boxed">

        <!--CONTENT CONTAINER-->
        <!--===================================================-->
        <div id="content-container">

            <!--Page Title-->
            @include('admin.base.title')
            <!--End page title-->


            <!--Page content-->
            @yield('content')
            <!--End page content-->


        </div>
        <!--===================================================-->
        <!--END CONTENT CONTAINER-->


        <!--MAIN NAVIGATION-->
        @include('admin.base.aside')
        <!--END MAIN NAVIGATION-->

    </div>
    <!-- FOOTER -->
    @include("admin.base.footer")
    <!-- END FOOTER -->

</div>
<!--===================================================-->
<!-- END OF CONTAINER -->
@yield('script')
</body>
</html>

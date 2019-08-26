<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OA商户后台管理</title>

    <link href="{{asset('plugins/layer/skin/layer.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.pjax.min.js')}}"></script>
    <script src="{{asset('plugins/layer/layer.js')}}"></script>

    <link href="{{mix('css/merchant.all.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{mix('js/merchant.all.js')}}"></script>

</head>

<body>
@include("merchant.base.header")
<div id="container" class="mainnav-lg">
    <!--Page content-->
    <div id="pjax-container">
        @yield('content')
    </div>
    <!--End page content-->
</div>
<!-- FOOTER -->
@include("merchant.base.footer")
<!-- END FOOTER -->


<!--===================================================-->
<!-- END OF CONTAINER -->
@yield('script')

</body>
</html>

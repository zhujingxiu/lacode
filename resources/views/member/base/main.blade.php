<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>欢迎使用 -- OA</title>
    <link rel="stylesheet" type="text/css" href="{{mix('css/app.css')}}">
    <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.12.0/dist/axios.min.js"></script>
    <script type="text/javascript" src="{{asset('js/member.all.js')}}"></script>
</head>
<body id="app">
@include("member.base.header")
<div id="container" class="mainnav-lg">
    <div id="sidebar">
    @include("member.base.sidebar")
    </div>
    <!--Page content-->
    <div id="page-content">
        @yield('content')
    </div>
    <!--End page content-->
</div>
<!-- FOOTER -->
@include("member.base.footer")
<!-- END FOOTER -->


<!--===================================================-->
<!-- END OF CONTAINER -->
@yield('script')

</body>
</html>
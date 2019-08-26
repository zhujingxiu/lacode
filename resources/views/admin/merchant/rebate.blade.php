@extends('admin.base.main')
@section('content')
    <div id="page-content">
        <div class="row">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <a class="btn btn-primary" id="rebates-save">
                            <i class="ion-document-text"></i> 保存
                        </a>
                    </div>
                    <h3 class="panel-title">商户退水-{{$merchant->nick_name}}</h3>
                </div>
                <div class="panel-body">
                    <form action="{{route('admin.merchant-rebates',$merchant)}}" id="rebates-form" method="post">
                        {{csrf_field()}}
                    <div class="form-group">

                        <div class="tab-base">
                            <ul class="nav nav-tabs tabs-right">
                                @foreach($games as $game)
                                    <li
                                            @if ($loop->first)
                                            class="active"
                                            @endif
                                    >
                                        <a data-toggle="tab" href="#group-content-{{$loop->iteration}}">{{$game->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($games as $game)
                                    @if ($loop->first)
                                        <div id="group-content-{{$loop->iteration}}" class="tab-pane fade active in">
                                    @else
                                        <div id="group-content-{{$loop->iteration}}" class="tab-pane fade">
                                    @endif
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th colspan="7" class="text-center">大項快速設置【注意：設置高於上級最高限制時按最高可調】</th>
                                                </tr>
                                                <tr>
                                                    <th class="text-center">彩标类型</th>
                                                    <th class="text-center">A盘</th>
                                                    <th class="text-center">B盘</th>
                                                    <th class="text-center">C盘</th>
                                                    <th class="text-center">单注限额</th>
                                                    <th class="text-center">单期限额</th>
                                                    <th class="text-center"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($game->rebates as $key => $rebate)
                                                    <tr>
                                                        <td class="text-center">{{trait_type($key, 1)}}</td>
                                                        <td class="text-center"><input type="text" class="form-control" name="rebate[{{$key}}][{{$game->id}}][a_limit]" value="{{$rebate['a_limit']}}"></td>
                                                        <td class="text-center"><input type="text" class="form-control" name="rebate[{{$key}}][{{$game->id}}][b_limit]" value="{{$rebate['b_limit']}}"></td>
                                                        <td class="text-center"><input type="text" class="form-control" name="rebate[{{$key}}][{{$game->id}}][c_limit]" value="{{$rebate['c_limit']}}"></td>
                                                        <td class="text-center"><input type="text" class="form-control" name="rebate[{{$key}}][{{$game->id}}][bet_limit]" value="{{$rebate['bet_limit']}}"></td>
                                                        <td class="text-center"><input type="text" class="form-control" name="rebate[{{$key}}][{{$game->id}}][issue_limit]" value="{{$rebate['issue_limit']}}"></td>
                                                        <td class="text-center"><a class="btn btn-warning">修改</a></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">类型</th>
                                                    <th class="text-center">彩标</th>
                                                    <th class="text-center">A盘</th>
                                                    <th class="text-center">B盘</th>
                                                    <th class="text-center">C盘</th>
                                                    <th class="text-center">单注限额</th>
                                                    <th class="text-center">单期限额</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($game->options as $option)
                                                        @php
                                                        $_rebate = isset($merchant_rebates[$option->id]) ? $merchant_rebates[$option->id] : [];
                                                        $_a_limit = isset($_rebate['a_limit']) ? $_rebate['a_limit'] :'';
                                                        $_b_limit = isset($_rebate['b_limit']) ? $_rebate['b_limit'] :'';
                                                        $_c_limit = isset($_rebate['c_limit']) ? $_rebate['c_limit'] :'';
                                                        $_bet_limit = isset($_rebate['bet_limit']) ? $_rebate['bet_limit'] :'';
                                                        $_issue_limit = isset($_rebate['issue_limit']) ? $_rebate['issue_limit'] :'';
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center"><label class="label label-primary">{{trait_type($option->trait)}}</label></td>
                                                            <td class="text-center"><label class="label label-success">{{$option->title}}</label></td>
                                                            <td><input type="text" class="form-control" name="rebate[{{$option->id}}][a_limit]" value="{{$_a_limit}}"></td>
                                                            <td><input type="text" class="form-control" name="rebate[{{$option->id}}][b_limit]" value="{{$_b_limit}}"></td>
                                                            <td><input type="text" class="form-control" name="rebate[{{$option->id}}][c_limit]" value="{{$_c_limit}}"></td>
                                                            <td><input type="text" class="form-control" name="rebate[{{$option->id}}][bet_limit]" value="{{$_bet_limit}}"></td>
                                                            <td><input type="text" class="form-control" name="rebate[{{$option->id}}][issue_limit]" value="{{$_issue_limit}}"></td>
                                                        </tr>
                                                        @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                @endforeach

                            </div>
                        </div>
                        
                    </div>
                </div>
                    </form>
            </div>
        </div>
    </div>
    @endsection
@section('script')
    <style>
        input.form-control{width: 99px}
        .tab-stacked-left .nav-tabs{width: 150px}
        .tab-base .nav-tabs>.active>a, .tab-base .nav-tabs>.active a:hover, .tab-base .nav-tabs>.active>a:focus{background-color: #0A89DA;color: #ffffff}
    </style>
            <script src="{{asset('js/jquery.form.js')}}"></script>
    <script>
        $(function () {
            $('#rebates-save').click(function () {
                $('#rebates-form').ajaxSubmit({
                    dataType:'json',
                    success:function (json) {
                        if(json.error_code==0){
                            $.niftyNoty({
                                type: 'success',
                                title: json.title,
                                message: json.msg,
                                container: 'floating',
                                timer: 3000
                            });
                            location.reload();
                        }else {

                        }
                    }
                })
            })
        })
    </script>
@endsection
@extends('admin.base.main')
@section('content')
<div id="page-content">
    <div class="row">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">彩种列表</h3>
            </div>

            <div class="panel-body">

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>彩种</th>
                        <th>标识</th>
                        <th>总期数</th>
                        <th>启用</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($games as $game)
                    <tr>
                        <td>{{$game->id}}</td>
                        <td><a class="btn-link">{{$game->title}}</a></td>
                        <td>{{$game->code}}</td>
                        <td>{{$game->total}}</td>
                        <td>
                            <input type="checkbox" class="magic-checkbox" id="game-status-{{$game->id}}"
                            @if($game->status)
                                checked
                                   @endif
                            >
                            <label for="game-status-{{$game->id}}">是</label>

                        </td>
                        <td>
                            @if($game->token)
                                <a class="btn btn-sm btn-rounded btn-info btn-default-option" data-default="bets" data-link="{{route('admin.game-bets', $game)}}">
                                    <i class="ion-wrench"></i> 彩注配置
                                </a>
                                <a class="btn btn-sm btn-rounded btn-info btn-default-option" data-default="options" data-link="{{route('admin.game-options', $game)}}">
                                    <i class="ion-gear-a"></i> 彩标配置
                                </a>
                                <a class="btn btn-sm btn-rounded btn-info btn-default-option" data-default="group" data-link="{{route('admin.game-groups', $game)}}">
                                    <i class="ion-gear-b"></i> 彩盘配置
                                </a>
                                <a class="btn btn-sm btn-rounded btn-info btn-default-option" data-default="rebates" data-link="{{route('admin.game-rebates', $game)}}">
                                    <i class="ion-calculator"></i> 默认退水
                                </a>
                                <a class="btn btn-sm btn-rounded btn-primary" href="{{route('admin.game-schedules', $game)}}">
                                    <i class="ion-calculator"></i> 开盘设置
                                </a>
                                <a class="btn btn-sm btn-rounded btn-primary" href="{{route('admin.game-odds', $game)}}">
                                    <i class="ion-calculator"></i> 默认赔率
                                </a>
                                <a class="btn btn-sm btn-rounded btn-danger btn-option" data-link="{{route('admin.game-uninstall', $game->id)}}">
                                    <i class="ion-trash-a"></i> 卸载
                                </a>
                            @else
                                <a class="btn btn-sm btn-rounded btn-info btn-option" data-link="{{route('admin.game-install', $game)}}">
                                    <i class="ion-gear-a"></i> 安装
                                </a>
                                <a class="btn btn-sm btn-rounded btn-danger btn-option" data-link="{{route('admin.game-delete', $game)}}">
                                    <i class="ion-trash-b"></i> 删除
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
@endsection
@section('script')
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script>
        $(function () {

            $('.btn-default-option').click(function () {
                var _url = $(this).data('link');
                $.getJSON(_url,{_t:Math.random()}, function (json) {
                    if(json.error_code>0){
                        $.niftyNoty({
                            type:  'danger',
                            title: json.title,
                            message: json.msg,
                            container: 'floating',
                            timer: 5000
                        });
                    }else{
                        if(json.data.tpl){
                            layer.open({
                                title: json.data.title,
                                content: json.data.tpl,
                                area: '880px',
                                offset: '100px',
                                btn: ['保存', '恢复默认值'],
                                yes: function () {
                                    $('#form-game-option').ajaxSubmit({
                                        dataType: 'json',
                                        success: function (json) {
                                            $.niftyNoty({
                                                type: json.error_code > 0 ? 'danger' : 'success',
                                                title: json.title,
                                                message: json.msg,
                                                container: 'floating',
                                                timer: json.error_code > 0 ? 5000 : 3000
                                            });
                                            if (json.error_code == 0) {
                                                location.reload()
                                            }
                                        },
                                    });
                                },
                                btn2:function () {
                                    layer.confirm('确认恢复到默认设置吗？',{icon:3, title:'确认'},function () {
                                        $.post(_url,{'_token':'{{csrf_token()}}','default':1},function (json) {
                                            $.niftyNoty({
                                                type: json.error_code > 0 ? 'danger' : 'success',
                                                title: json.title,
                                                message: json.msg,
                                                container: 'floating',
                                                timer: json.error_code > 0 ? 5000 : 3000
                                            });
                                            if (json.error_code == 0) {
                                                location.reload()
                                            }
                                        },json)
                                    })
                                }
                            });
                        }
                    }
                });

            })
        });

    </script>
@endsection


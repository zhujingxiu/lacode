@extends('admin.base.main')
@section('content')
<div id="page-content">
    <div class="row">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">
                    <select id="change-game-schedule">
                        @foreach($games as  $_game)
                        <option value="{{$_game->id}}" data-link="{{route('admin.game-schedules',$_game)}}"
                                @if($game->id==$_game->id)
                                    selected
                                    @endif
                            >{{$_game->title}}</option>
                            @endforeach
                    </select>
                </div>
                <h3 class="panel-title">彩种列表</h3>
            </div>

            <div class="panel-body">
                <div class="form-group">
                    <table class="table table-striped">
                    <thead>
                    <tr>
                        <td></td>
                        <td>起始时间</td>
                        <td>总期数</td>
                        <td>期数间隔</td>
                        <td>封盘提前</td>
                        <td>排序</td>
                        <td>启用</td>
                        <td><a class="btn btn-primary btn-restore hidden" data-rel="{{$game->id}}" data-link="{{route('admin.game-schedules',$game)}}">恢复默认</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="text" class="form-control" name="new[{{$game->id}}][start_time]" ></td>
                        <td><input type="text" class="form-control" name="new[{{$game->id}}][total]" style="width:100px" ></td>
                        <td><input type="text" class="form-control" name="new[{{$game->id}}][interval]" style="width:100px" ></td>
                        <td><input type="text" class="form-control" name="new[{{$game->id}}][ahead]" style="width:100px" ></td>
                        <td><input type="text" class="form-control" name="new[{{$game->id}}][sort]" style="width:100px" ></td>
                        <td></td>
                        <td><a class="btn btn-primary btn-add" data-rel="{{$game->id}}" data-link="{{route('admin.game-schedules',$game)}}">添加时段</a></td>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($game->schedules as $schedule)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><input type="text" class="form-control" name="schedule[{{$schedule->id}}][start_time]" value="{{$schedule->start_time}}"></td>
                            <td><input type="text" class="form-control" name="schedule[{{$schedule->id}}][total]" value="{{$schedule->total}}" style="width:100px"></td>
                            <td><input type="text" class="form-control" name="schedule[{{$schedule->id}}][interval]" value="{{$schedule->interval}}" style="width:100px"></td>
                            <td><input type="text" class="form-control" name="schedule[{{$schedule->id}}][ahead]" value="{{$schedule->ahead}}" style="width:100px"></td>
                            <td><input type="text" class="form-control" name="schedule[{{$schedule->id}}][sort]" value="{{$schedule->sort}}" style="width:100px"></td>
                            <td><input type="checkbox" class="magic-checkbox" name="schedule[{{$schedule->id}}][status]" value="1" id="schedule-status-{{$schedule->id}}"
                                       @if($schedule->status)
                                       checked
                                       @endif
                                >
                                <label for="schedule-status-{{$schedule->id}}">是</label>
                            </td>
                            <td><a class="btn btn-warning btn-edit" data-rel="{{$schedule->id}}" data-link="{{route('admin.game-schedules',$game)}}">修改</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <a data-link="{{route('admin.game-schedules',$game)}}" class="btn btn-block btn-success load-issues"> 加 载 盘 口 </a>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td></td>
                        <td>期数</td>
                        <td>起投时间</td>
                        <td>封盘时间</td>
                        <td>开奖时间</td>
                        <td>状态</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($game->schedule_issues as $schedule_issue)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$schedule_issue->issue}}</td>
                        <td>{{$schedule_issue->start_time}}</td>
                        <td>{{$schedule_issue->end_time}}</td>
                        <td>{{$schedule_issue->open_time}}</td>
                        <td>{{$schedule_issue->status}}</td>
                        <td></td>
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
    <script>
        $(function () {
            $('#change-game-schedule').change(function(){
                var _option = $(this).find('option:selected')
                location.href = _option.data('link')
            });
            $('.load-issues').click(function () {
                var url = $(this).data('link');
                $.getJSON(url,{_t:Math.random()},function (json) {
                    layer.closeAll();
                    $.niftyNoty({
                        type: json.error_code>0 ? 'danger' :'success',
                        title: json.msg.title,
                        message: json.msg.text,
                        container: 'floating',
                        timer: json.error_code>0 ? 5000 : 3000
                    });
                    if(json.error_code == 0){
                        location.reload();
                    }
                })
            });
            $('.btn-add').click(function () {
                var url = $(this).data('link');
                var rel = $(this).data('rel');
                var _title = $('input[name="new['+rel+'][title]"]').val();
                var _total = $('input[name="new['+rel+'][total]"]').val();
                var _interval = $('input[name="new['+rel+'][interval]"]').val();
                var _ahead = $('input[name="new['+rel+'][ahead]"]').val();
                var _sort = $('input[name="new['+rel+'][sort]"]').val();

                layer.confirm('确认添加吗，添加完成后需要重新加载该彩种盘口，才可生效', {icon: 3, title:'提示'}, function(index){
                    $.post(url,{_token:'{{csrf_token()}}',title:_title,total:_total,interval:_interval,ahead:_ahead,sort:_sort},function (json) {
                        layer.closeAll();
                        $.niftyNoty({
                            type: json.error_code>0 ? 'danger' :'success',
                            title: json.msg.title,
                            message: json.msg.text,
                            container: 'floating',
                            timer: json.error_code>0 ? 5000 : 3000
                        });
                        if(json.error_code == 0){
                            location.reload();
                        }
                    },'json')
                });
            });

            $('.btn-edit').click(function () {
                var url = $(this).data('link');
                var rel = $(this).data('rel');
                var _title = $('input[name="schedule['+rel+'][title]"]').val();
                var _total = $('input[name="schedule['+rel+'][total]"]').val();
                var _interval = $('input[name="schedule['+rel+'][interval]"]').val();
                var _ahead = $('input[name="schedule['+rel+'][ahead]"]').val();
                var _status = $('input[name="schedule['+rel+'][status]"]:checked').val();
                var _sort = $('input[name="schedule['+rel+'][sort]"]').val();
                layer.confirm('确认修改吗，修改完成后需要重新加载该彩种盘口，才可生效', {icon: 3, title:'提示'}, function(index){
                    $.post(url,{_token:'{{csrf_token()}}',schedule:rel,title:_title,total:_total,interval:_interval,ahead:_ahead,sort:_sort,status:_status},function (json) {
                        layer.closeAll();
                        $.niftyNoty({
                            type: json.error_code>0 ? 'danger' :'success',
                            title: json.msg.title,
                            message: json.msg.text,
                            container: 'floating',
                            timer: json.error_code>0 ? 5000 : 3000
                        });
                        if(json.error_code == 0){
                            location.reload();
                        }
                    },'json')
                });
            });
        });

    </script>
@endsection


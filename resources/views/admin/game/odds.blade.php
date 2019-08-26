@extends('admin.base.main')
@section('content')
    <div id="page-content">
        <div class="row">
            <div class="panel">
    <div class="panel-body odds-box">
        <div class="col-sm-7">
            <div class="tab-base" >
                <ul class="nav nav-tabs tabs-right">
                    @php
                        $index = 0;
                    @endphp
                    @foreach($groups as $group)
                        <li
                        @if ($loop->first)
                             class="active"
                        @endif
                            >
                                <a data-toggle="tab" href="#group-content-{{$loop->iteration}}">{{$group->title}}</a>
                        </li>
                        @php
                            $index = $loop->iteration;
                        @endphp
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach($groups as $group)
                        @if ($loop->first)
                            <div id="group-content-{{$loop->iteration}}" class="tab-pane fade active in">
                        @else
                            <div id="group-content-{{$loop->iteration}}" class="tab-pane fade">
                        @endif
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <td></td>
                                        <td>B,C盘赔率差</td>
                                        <td>平铺方式</td>
                                        <td>彩注数量</td>
                                        <td>显示标题</td>
                                        <td>排序</td>
                                        <td style="display: none">样式</td>
                                        <td>入盘</td>
                                        <td>彩标</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $odds_group_options = isset($odds_options[$group->id]) ? $odds_options[$group->id] : [];
                                    @endphp
                                    @foreach($options as $option)
                                        @php
                                            $_odds_group_option = array_key_exists($option->id,$odds_group_options) ? $odds_group_options[$option->id] : [];
                                            $_join = $_odds_group_option ? 'checked' : '';
                                            $_show = empty($_odds_group_option['show']) ? '' :'checked';
                                            $_repeat = isset($_odds_group_option['repeat']) ? $_odds_group_option['repeat'] :'horizontal';
                                            $_max = isset($_odds_group_option['max']) ? $_odds_group_option['max'] :'';
                                            $_style = isset($_odds_group_option['style']) ? $_odds_group_option['style'] :'';
                                            $_sort = isset($_odds_group_option['sort']) ? $_odds_group_option['sort'] :0;
                                        @endphp
                                        <tr id="group-option-{{$group->id}}-{{$option->id}}" data-group="{{$group->id}}" data-option="{{$option->id}}" class="option-item">
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                {{$option->diff_b}} - {{$option->diff_c}}
                                                <input type="hidden" class="form-control option-diff-b" value="{{$option->diff_b}}">
                                                <input type="hidden" class="form-control option-diff-c" value="{{$option->diff_c}}">
                                            </td>
                                            <td><select class="form-control option-repeat" id="option-repeat-{{$group->id}}-{{$option->id}}">
                                                    <option value="horizontal" {{$_repeat=='horizontal' ? 'selected': ''}}>水平</option>
                                                    <option value="vertical" {{$_repeat=='vertical' ? 'selected': ''}}>垂直</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control option-max" value="{{$_max}}"></td>
                                            <td>
                                                <input type="checkbox" class="magic-checkbox option-show" value="1" id="option-show-{{$group->id}}-{{$option->id}}" {{$_show}}>
                                                <label for="option-show-{{$group->id}}-{{$option->id}}">是</label>
                                            </td>
                                            <td><input type="text" class="form-control option-sort" value="{{$_sort}}"></td>
                                            <td style="display: none"><input type="text" class="form-control option-style" value="{{$_style}}"></td>
                                            <td>
                                                <input type="checkbox" class="magic-checkbox option-join" value="1" id="option-join-{{$group->id}}-{{$option->id}}" {{$_join}} >
                                                <label for="option-join-{{$group->id}}-{{$option->id}}">是</label>
                                            </td>

                                            <td>
                                                <label class="label label-info">{{$option->title}}</label>
                                                <label class="label label-success">{{trait_type($option->trait)}}</label>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <select id="change-game-schedule">
                            @foreach($games as  $_game)
                                <option value="{{$_game->id}}" data-link="{{route('admin.game-odds',$_game)}}"
                                        @if($game->id==$_game->id)
                                        selected
                                        @endif
                                >{{$_game->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <h3 class="panel-title" id="option-bet-title">彩注列表</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group clearfix" style="position: fixed;top:200px;right:600px">
                            <input type="email" placeholder="快捷输入" id="fast-input" class="form-control">
                    </div>
                    <div id="option-bet-list" >
                        <div class="bg-info text-lg-center pad-all">请选则一个彩标入盘，再编辑彩注...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
@endsection
@section('script')
<style>
    input.form-control{width: 80px}
    .tab-stacked-left .nav-tabs{width: 150px}
    .tab-base .nav-tabs>.active>a, .tab-base .nav-tabs>.active a:hover, .tab-base .nav-tabs>.active>a:focus{background-color: #0A89DA;color: #ffffff}
</style>
<script src="{{asset('js/jquery.form.js')}}"></script>
<script>
    $(function () {
        $('#change-game-schedule').change(function(){
            var _option = $(this).find('option:selected')
            location.href = _option.data('link')
        });
        $('.odds-box').delegate('input.form-control:not(#fast-input):not([readonly])','focus',function () {
            var _value = $('#fast-input').val();
            $(this).val(_value);
        });
        $('.option-join').change(function () {
            var thistr = $(this).parent().parent();
            if($(this).prop("checked")){
                thistr.find('.option-show').prop('disabled', false).prop('checked', true);
                var _group = thistr.data('group');
                var _option = thistr.data('option');
                load_option_bets(_option,_group,0,0);
            }else{
                thistr.find('.option-show').prop('disabled', true).prop('checked', false);
                $('#option-bet-title').html('彩注列表');
                $('#option-bet-list').html('<div class="bg-info text-lg-center pad-all">请选则一个彩标入盘，再编辑彩注...</div>')
            }
        });
        $('.option-item').dblclick(function () {
            if($(this).find('.option-join').prop('checked')){
                $(this).find('.odds-show').prop('disabled', false).prop('checked', true);
                var _group = $(this).data('group');
                var _option = $(this).data('option');
                load_option_bets(_option,_group,0,0);
            }else{
                layer.msg('该彩标尚未入盘，请入盘后再加载彩注表单',{icon:5});
                return false;
            }
        })
    });
    function load_option_bets(_option,_group,_copyOption,_copyGroup) {
        var _url = '{{route('admin.game-option-bets',$game)}}';
        $('#option-bet-list').html('<i class="ion-load-a"></i> 加载中，请稍后...');
        $.getJSON(_url,{_t:Math.random(),option:_option,group:_group,copy_option:_copyOption,copy_group:_copyGroup},function (json) {
            if(json.error_code==0){
                if(json.data.tpl) {
                    $('#option-bet-title').html(json.data.title);
                    $('#option-bet-list').html(json.data.tpl)
                }else {
                    $.niftyNoty({
                        type: 'success',
                        title: json.title,
                        message: json.msg,
                        container: 'floating',
                        timer: 3000
                    });
                    location.reload();
                }
            }else {
                $.niftyNoty({
                    type: 'danger',
                    title: json.title,
                    message: json.msg,
                    container: 'floating',
                    timer: 5000
                });
            }
        })
    }
</script>
@endsection
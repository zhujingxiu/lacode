<div class="panel">
    <div class="panel-body">
        <form action="{{route('admin.game-groups', $game)}}" method="POST" class="form-horizontal" id="form-game-option">
            {{csrf_field()}}
            <div class="form-group">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td></td>
                        <td>标题</td>
                        <td>标识</td>
                        <td>排序</td>
                        <td>启用</td>
                        <td><a class="btn btn-info btn-xs btn-add"><i class="ion-plus"></i>添加</a></td>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = 0;
                        @endphp
                        @foreach($groups as $group)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><input type="text" class="form-control" name="group[{{$loop->iteration}}][title]" value="{{$group->title}}"></td>
                                <td><input type="text" class="form-control" name="group[{{$loop->iteration}}][code]" value="{{$group->code}}"></td>
                                <td><input type="text" class="form-control" name="group[{{$loop->iteration}}][sort]" value="{{$group->sort}}"></td>
                                <td><input type="checkbox" class="magic-checkbox" name="group[{{$loop->iteration}}][status]" value="1" id="group-status-{{$loop->iteration}}"
                                       @if($group->status)
                                       checked
                                        @endif
                                >
                                <label for="group-status-{{$loop->iteration}}">是</label></td>
                                <td><a class="btn btn-sm btn-danger" onclick="$(this).parent().parent().remove();">
                                        <i class="ion-trash-a"></i> 删除</a>
                                </td>
                            </tr>
                            @php
                                $index = $loop->iteration;
                            @endphp
                            @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<style>
    #form-game-option table td>.form-control{ width: 130px;}
</style>
<script>
    var index = parseInt('{{$index}}');
    $('.btn-add').click(function () {
        index++;
        var _html = '<tr>';
        _html += '<td>'+index+'</td>';
        _html += '<td><input type="text" class="form-control" name="group['+index+'][title]"></td>';
        _html += '<td><input type="text" class="form-control" name="group['+index+'][code]"></td>';
        _html += '<td><input type="text" class="form-control" name="group['+index+'][sort]"></td>';
        _html += '<td><input type="checkbox" class="magic-checkbox" name="group['+index+'][status]" value="1" id="group-status-"'+index+' checked>';
        _html += '<label for="group-status-"'+index+'>是</label></td>';
        _html += '<td><a class="btn btn-sm btn-danger" onclick="$(this).parent().parent().remove();"><i class="ion-trash-a"></i> 删除</a></td>';
        _html += '</tr>';
        $('#form-game-option table > tbody').append(_html)
    })
</script>
<div class="panel">
    <div class="panel-body">
        <form action="{{route('admin.game-bets',$game)}}" method="POST" class="form-horizontal" id="form-game-option">
            {{csrf_field()}}
            <div class="scroll-box form-group" style="max-height:330px;overflow-y: scroll">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td></td>
                        <td>标题</td>
                        <td>标识</td>
                        <td>样式类</td>
                        <td>排序</td>
                        <td><a class="btn btn-info btn-xs btn-add"><i class="ion-plus"></i>添加</a></td>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = 0;
                        @endphp
                        @foreach($bets as $bet)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><input type="text" class="form-control" name="bet[{{$loop->iteration}}][title]" value="{{$bet->title}}"></td>
                                <td><input type="text" class="form-control" name="bet[{{$loop->iteration}}][code]" value="{{$bet->code}}"></td>
                                <td><input type="text" class="form-control" name="bet[{{$loop->iteration}}][style]" value="{{$bet->style}}"></td>
                                <td><input type="text" class="form-control" name="bet[{{$loop->iteration}}][sort]" value="{{$bet->sort}}"></td>

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
    #form-game-option table td>.form-control{ width: 100px;}
</style>
<script>
    var index = parseInt('{{$index}}');
    $('.btn-add').click(function () {
        index++;
        var _html = '<tr>';
        _html += '<td>'+index+'</td>';
        _html += '<td><input type="text" class="form-control" name="bet['+index+'][title]" value=""></td>';
        _html += '<td><input type="text" class="form-control" name="bet['+index+'][code]" value=""></td>';
        _html += '<td><input type="text" class="form-control" name="bet['+index+'][style]" value=""></td>';
        _html += '<td><input type="text" class="form-control" name="bet['+index+'][sort]" value=""></td>';

        _html += '<td><a class="btn btn-sm btn-danger" onclick="$(this).parent().parent().remove();"><i class="ion-trash-a"></i> 删除</a></td>';
        _html += '</tr>';
        $('#form-game-option table > tbody').append(_html)
    })
</script>
<div class="panel">
    <div class="panel-body">
        <form action="{{route('admin.game-options',$game)}}" method="POST" class="form-horizontal" id="form-game-option">
            {{csrf_field()}}
            <div class="scroll-box form-group" style="max-height:330px;overflow-y: scroll">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td></td>
                        <td>类别</td>
                        <td>标题</td>
                        <td>标识</td>
                        <td>B盘赔率差</td>
                        <td>C盘赔率差</td>
                        <td>排序</td>
                        <td><a class="btn btn-info btn-xs btn-add"><i class="ion-plus"></i>添加</a></td>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = 0;
                        @endphp
                        @foreach($options as $option)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><select name="option[{{$loop->iteration}}][trait]" class="form-control">
                                        @foreach($traits as $key => $value)
                                            <option value="{{$key}}"
                                                    @if($option->trait == $key)
                                                    selected
                                                    @endif
                                            >{{$value}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="option[{{$loop->iteration}}][title]" value="{{$option->title}}"></td>
                                <td><input type="text" class="form-control" name="option[{{$loop->iteration}}][code]" value="{{$option->code}}"></td>
                                <td><input type="text" class="form-control" name="option[{{$loop->iteration}}][diff_b]" value="{{$option->diff_b}}"></td>
                                <td><input type="text" class="form-control" name="option[{{$loop->iteration}}][diff_c]" value="{{$option->diff_c}}"></td>
                                <td><input type="text" class="form-control" name="option[{{$loop->iteration}}][sort]" value="{{$option->sort}}"></td>
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
        _html += '<td><select class="form-control" name="option['+index+'][trait]">';
        @foreach($traits as $key => $value)
            _html += '<option value="{{$key}}">{{$value}}</option>';
        @endforeach
            _html +='</td>';
        _html += '<td><input type="text" class="form-control" name="option['+index+'][title]" value=""></td>';
        _html += '<td><input type="text" class="form-control" name="option['+index+'][code]" value=""></td>';
        _html += '<td><input type="text" class="form-control" name="option['+index+'][diff_b]" value=""></td>';
        _html += '<td><input type="text" class="form-control" name="option['+index+'][diff_c]" value=""></td>';
        _html += '<td><input type="text" class="form-control" name="option['+index+'][sort]" value=""></td>';
        _html += '<td><a class="btn btn-sm btn-danger" onclick="$(this).parent().parent().remove();"><i class="ion-trash-a"></i> 删除</a></td>';
        _html += '</tr>';
        $('#form-game-option table > tbody').append(_html)
    })
</script>
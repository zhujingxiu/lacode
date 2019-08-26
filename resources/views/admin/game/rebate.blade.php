<div class="panel">
    <div class="panel-body">
        <form action="{{route('admin.game-rebates', $game)}}" method="POST" class="form-horizontal" id="form-game-option">
            {{csrf_field()}}
            <div class="form-group">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td></td>
                        <td>类型</td>
                        <td>A盘退水</td>
                        <td>B盘退水</td>
                        <td>C盘退水</td>
                        <td>单注限额</td>
                        <td>单期限额</td>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($rebates as $key => $rebate)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{trait_type($key)}}</td>
                                <td><input type="text" class="form-control" name="rebate[{{$key}}][a_limit]" value="{{$rebate['a_limit']}}"></td>
                                <td><input type="text" class="form-control" name="rebate[{{$key}}][b_limit]" value="{{$rebate['b_limit']}}"></td>
                                <td><input type="text" class="form-control" name="rebate[{{$key}}][c_limit]" value="{{$rebate['c_limit']}}"></td>
                                <td><input type="text" class="form-control" name="rebate[{{$key}}][bet_limit]" value="{{$rebate['bet_limit']}}"></td>
                                <td><input type="text" class="form-control" name="rebate[{{$key}}][issue_limit]" value="{{$rebate['issue_limit']}}"></td>

                            </tr>
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

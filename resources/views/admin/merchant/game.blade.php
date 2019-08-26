<div class="panel">
    <div class="panel-body">
        <form id="merchant-game-form" method="post" class="form-horizontal" action="{{route('admin.merchant-games')}}">
            {{csrf_field()}}
            <div class="col-sm-12">

            </div>
            <table class="table table-striped table-bordered">
                <tbody>
                @foreach($merchants as $merchant)
                    <tr>
                        <td colspan="4">{{$merchant->name}}</td>
                    </tr>
                    @php
                    $merchant_games = $merchant->games;
                    @endphp
                        @foreach($games as $game)
                            @php
                            $_checked = in_array($game->id,$merchant_games) ? 'checked' :'';
                                    @endphp
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$game->title}}</td>
                            <td><input type="checkbox" name="game[{{$merchant->id}}][{{$game->id}}][status]" class="magic-checkbox" value="1" id="game-{{$merchant->id}}-{{$loop->iteration}}" {{$_checked}}>
                                <label for="game-{{$merchant->id}}-{{$loop->iteration}}">开启</label>
                            </td>
                        </tr>
                        @endforeach
                @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>
<script>

    $(function () {

        $("#merchant-game-form").validate({
            submitHandler : function(form){
                $(form).ajaxSubmit({
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
            }
        });
    })
</script>
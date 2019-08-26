<form action="{{route('admin.game-option-bets', $game)}}" method="post" id="option-bets-form">
    {{csrf_field()}}
    <input type="hidden" value="{{$group->id}}" name="group_id">
    <input type="hidden" value="{{$option->id}}" name="option[id]">
    <input type="hidden" name="option[join]">
    <input type="hidden" name="option[show]">
    <input type="hidden" name="option[sort]">
    <input type="hidden" name="option[style]">
    <input type="hidden" name="option[repeat]">
    <input type="hidden" name="option[max]">
    <div class="form-group">
        <table class="table table-striped">
            <thead>
            <tr>
                <td></td>
                <td>标题</td>
                <td>入标</td>
                <td>A赔率</td>
                <td>B赔率</td>
                <td>C赔率</td>
                <td>默认</td>
            </tr>
            </thead>
            <tbody>
            @foreach($bets as $bet)
                @php
                $_bet = isset($odds_bets[$bet->id]) ? $odds_bets[$bet->id] : [];
                $_join = $_bet ? 'checked' :'';
                $_disabled = $_bet ? 'readonly' :'disabled';
                $_a_val = isset($_bet['a']) ? $_bet['a'] : 0;
                $_b_val = isset($_bet['b']) ? $_bet['b'] : 0;
                $_c_val = isset($_bet['c']) ? $_bet['c'] : 0;
                $_d_val = isset($_bet['d']) ? $_bet['d'] : $_a_val;
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$bet->title}}</td>
                    <td><input type="checkbox" class="magic-checkbox bet-join" name="bet[{{$bet->id}}][join]" value="1" id="bet-join-{{$bet->id}}" {{$_join}}>
                        <label for="bet-join-{{$bet->id}}">是</label>
                    </td>
                    <td><input type="text" class="form-control bet-value-a" name="bet[{{$bet->id}}][a]" value="{{$_a_val}}" {{$_disabled}}></td>
                    <td><input type="text" class="form-control bet-value-b" name="bet[{{$bet->id}}][b]" value="{{$_a_val}}" {{$_disabled}} readonly></td>
                    <td><input type="text" class="form-control bet-value-c" name="bet[{{$bet->id}}][c]" value="{{$_a_val}}" {{$_disabled}} readonly></td>
                    <td><input type="text" class="form-control bet-value-d" name="bet[{{$bet->id}}][d]" value="{{$_d_val}}" {{$_disabled}}></td>
                </tr>

            @endforeach
        </tbody>

    </table>

        <a class="btn btn-primary" id="option-bets-save" style="position: fixed;top:200px;right:20px">
            <i class="ion-levels"></i> 保存
        </a>
    </div>
    @if($otherOddsOptions)
    <div class="form-group">
        <label class="col-sm-3 control-label" for="copy-option-bet">复制彩标设置</label>
        <div class="col-sm-9">
            <select id="copy-odds-bet" class="form-control">
                <option>请选择要复制的彩标</option>
                @foreach($otherOddsOptions as $oddsOptions)
                    @foreach($oddsOptions as $item)
                        @php
                        if($item->group_id == $group->id && $item->option_id == $option->id){
                            continue;
                        }
                        @endphp
                    <option value="{{$loop->iteration}}" data-option="{{$item->option->id}}" data-group="{{$item->group->id}}">
                        {{$item->group->title}} -- {{$item->option->title}}
                    </option>
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>
        @endif
</form>
<script>
    var _group_option = $('#group-option-{{$group->id}}-{{$option->id}}');
    var _diff_b = parseFloat(_group_option.find('.option-diff-b').val()).toFixed(3);
    var _diff_c = parseFloat(_group_option.find('.option-diff-c').val()).toFixed(3);

    $('.bet-value-a').bind("input propertychange blur",function () {
        var _value = parseFloat($(this).val()).toFixed(3) || 0.000;
        if(!$.isNumeric(_value)){
            layer.tips('请输入数字',$(this));
            $(this).val('0');
            return false;
        }
        var thistr = $(this).parent().parent();
        if(!$.isNumeric(_diff_b)){
            layer.tips('请输入数字',thistr.find('.bet-value-b'));
            return false;
        }else{
            thistr.find('.bet-value-b').val(_value > _diff_b ?math_sub(_value,_diff_b) : 0.000);
        }
        if(!$.isNumeric(_diff_c)){
            layer.tips('请输入数字',thistr.find('.bet-value-c'));
            return false;
        }else{
            thistr.find('.bet-value-c').val(_value > _diff_c ?math_sub(_value,_diff_c) : 0.000);
        }

    });
    $('#option-bets-save').click(function () {
        var _show = _group_option.find('.option-show:checked').val();
        var _join = _group_option.find('.option-join:checked').val();
        var _sort = _group_option.find('.option-sort').val();
        var _style = _group_option.find('.option-style').val();
        var _max = _group_option.find('.option-max').val();
        var _repeat = _group_option.find('.option-repeat').val();
        $('#option-bets-form [name="option[show]"]').val(parseInt(_show));
        $('#option-bets-form [name="option[join]"]').val(parseInt(_join));
        $('#option-bets-form [name="option[style]"]').val(_style);
        $('#option-bets-form [name="option[sort]"]').val(_sort);
        $('#option-bets-form [name="option[max]"]').val(_max);
        $('#option-bets-form [name="option[repeat]"]').val(_repeat);
        $('#option-bets-form').ajaxSubmit({
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
    });
    $('.bet-join').change(function () {
        var thistr = $(this).parent().parent();
        if($(this).prop("checked")){
            var _value = $('#fast-input').val();
            thistr.find('input[disabled]').prop('disabled', false);
            if($.isNumeric(_value)){
                thistr.find('input.bet-value-d').val(_value);
                thistr.find('input.bet-value-a').val(_value).trigger('blur');
            }
        }else{
            thistr.find('input[type="text"]').prop('disabled', true);
        }
    });
    $('#copy-odds-bet').change(function () {
        layer.confirm('确认复制吗？加载后请保存',{'icon':3,'title':'确认'},function () {
            var _option = $('#copy-odds-bet').find('option:selected');
            var _copyOption = _option.data('option');
            var _copyGroup = _option.data('group');
            layer.closeAll();
            load_option_bets('{{$option->id}}','{{$group->id}}',_copyOption,_copyGroup)
        });
    })
</script>
<div class="panel">
    <div class="panel-body">
        <form id="member-form" method="post" class="form-horizontal" action="{{route('admin.member-store')}}">
            {{csrf_field()}}
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-role">会员类型</label>
                <div class="col-sm-8">
                    <div class="radio">
                        <input type="radio" id="input-role-proxy" name="role" data-role="proxy" class="magic-radio merchant-role">
                        <label for="input-role-proxy">普通会员</label>
                        <input type="radio" id="input-role-company" name="role" data-role="company" class="magic-radio merchant-role">
                        <label for="input-role-company">公司直属</label>
                        <input type="radio" id="input-role-shareholder" name="role" data-role="shareholder" class="magic-radio merchant-role">
                        <label for="input-role-shareholder">股东直属</label>
                        <input type="radio" id="input-role-agent" name="role" data-role="agent" class="magic-radio merchant-role">
                        <label for="input-role-agent">总代理直属</label>
                    </div>
                </div>
                <div class="col-sm-1">
                    <span class="help-tips"></span>
                </div>
            </div>
            @foreach($role_merchants as $role => $merchants)
                <div class="form-group role-block" style="display: none" id="role-{{$role}}">
                    <label class="col-sm-3 control-label" for="input-merchant">上级账户</label>
                    <div class="col-sm-6">
                        <select name="merchant_id" id="input-merchant" class="form-control" disabled>
                            @foreach($merchants as $merchant)
                                <option data-balance="{{$merchant->info->credit}}" value="{{$merchant->id}}">{{$merchant->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <span class="help-tips"></span>
                    </div>
                </div>
                @endforeach
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-name">会员账户</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="会员账户" name="name" id="input-name" class="form-control"
                           autocomplete="false">
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-nickname">会员名称</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="会员名称" name="nick_name" id="input-nickname"
                           class="form-control" autocomplete="false">
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-password">新密码</label>
                <div class="col-sm-6">
                    <input type="password" placeholder="新密码" name="password" id="input-password" class="form-control"
                           autocomplete="false">
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-credit">信用额度</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="信用额度" name="credit" id="input-credit" class="form-control"
                           autocomplete="false" data-tip-upcase="#tip-credit-upcase">
                </div>
                <div class="col-sm-3">
                    <span id="tip-credit-upcase" class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-rate">代理占成</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="代理占成" name="rate" id="input-rate" class="form-control"
                           autocomplete="false">
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-share">开放盘口</label>
                <div class="col-sm-6">
                    <div class="radio">
                        <input type="radio" id="input-roulette-a" checked name="roulette" value="a"
                               class="magic-radio">
                        <label for="input-roulette-a">A盘</label>
                        <input type="radio" id="input-roulette-b" name="roulette" value="b" class="magic-radio">
                        <label for="input-roulette-b">B盘</label>
                        <input type="radio" id="input-roulette-c" name="roulette" value="c" class="magic-radio">
                        <label for="input-roulette-c">C盘</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-charges">退水设定</label>
                <div class="col-sm-6">
                    <select name="rebate" class="form-control">
                        @foreach($rebatesOptions as $val=>$option)
                        <option value="{{$val}}">{{$option}}</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $.validator.setDefaults({
        errorElement : 'span',
        errorClass : 'help-block',
        highlight : function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        success : function(label, element) {
            $(element).closest('.form-group').removeClass('has-error');
            label.remove();
        },
        errorPlacement : function(error, element) {
            if(error.text().length>0)
                layer.tips(error.text(), element,{tips: 1});
        }
    });
    $(function () {
        $('.merchant-role').change(function () {
            var _role = $(this).data('role');
            $('.role-block').css('display','none').find('select[name="merchant_id"]').prop('disabled',true);
            $('#role-'+_role).css('display','block').find('select[name="merchant_id"]').prop('disabled',false);
        });
        $('.merchant-role:first').trigger('click');

        $("#member-form").validate({
            rules : {},
            messages : {},
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
                    error: function (json) {
                        var _errors = json.responseJSON.data.errors;
                        for (var _key in _errors) {
                            $('#member-form [name="' + _key + '"]').parentsUntil('.form-group').parent().find('.help-tips').html(_errors[_key]);
                        }
                    }
                });
            }
        });
    })
</script>
<div class="panel">
    <div class="panel-body">
        <form id="merchant-form" method="post" class="form-horizontal" action="{{route('admin.merchant-store')}}">
            {{csrf_field()}}
            <input type="hidden" name="code" value="{{$role->code}}">
            @if($parents)
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="input-parent">{{$role->title}}上级账户</label>
                    <div class="col-sm-6">
                        <select name="parent_id" id="input-parent" class="form-control">
                            @foreach($parents as $merchant)
                            <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <span class="help-tips"></span>
                    </div>
                </div>
                @endif
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-name">{{$role->title}}账户</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="{{$role->title}}账户" name="name" id="input-name" class="form-control"
                           autocomplete="false">
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-nickname">{{$role->title}}名称</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="{{$role->title}}名称" name="nick_name" id="input-nickname"
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
                <label class="col-sm-3 control-label" for="input-rate">{{$role->title}}占成</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="{{$role->title}}占成" name="rate" id="input-rate" class="form-control"
                           autocomplete="false">
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-share">占余成数归</label>
                <div class="col-sm-6">
                    <div class="radio">
                        <input type="radio" id="input-rate-company-yes" checked name="rate_company" value="1"
                               class="magic-radio">
                        <label for="input-rate-company-yes">总公司</label>
                        <input type="radio" id="input-rate-company-no" name="rate_company" value="0"
                               class="magic-radio">
                        <label for="input-rate-company-no">分公司</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-share">补货功能</label>
                <div class="col-sm-6">
                    <div class="radio">
                        <input type="radio" id="input-replenish-yes" checked name="replenish" value="1"
                               class="magic-radio">
                        <label for="input-replenish-yes">开启</label>
                        <input type="radio" id="input-replenish-no" name="replenish" value="0" class="magic-radio">
                        <label for="input-replenish-no">关闭</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-share">状态</label>
                <div class="col-sm-6">
                    <div class="radio">
                        <input type="radio" id="input-status-yes" checked name="status" value="1" class="magic-radio">
                        <label for="input-status-yes">激活</label>
                        <input type="radio" id="input-status-" name="status" value="-1" class="magic-radio">
                        <label for="input-status-">冻结</label>
                        <input type="radio" id="input-status-no" name="status" value="0" class="magic-radio">
                        <label for="input-status-no">停用</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <span class="help-tips"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-charges">赚佣</label>
                <div class="col-sm-6">
                    <input type="text" placeholder="赚佣" name="charges" id="input-charges" class="form-control"
                           value="0">
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

        $("#merchant-form").validate({
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
                            $('#merchant-form [name="' + _key + '"]').parentsUntil('.form-group').parent().find('.help-tips').html(_errors[_key]);
                        }
                    }
                });
            }
        });
    })
</script>
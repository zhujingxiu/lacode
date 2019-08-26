@extends('admin.base.main')
@section('content')
    <div id="page-content">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <a class="btn btn-warning" id="config-save">
                            <i class="ion-document-text"></i> 保存
                        </a>
                    </div>
                    <h3 class="panel-title">基本参数</h3>
                </div>
                <div class="panel-body">
                    <form action="{{route('admin.config-store')}}" method="POST" id="config-form" class="form-horizontal">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label" >网站开放</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <input type="radio" id="input-web-lock-yes" checked name="g_web_lock" value="1" class="magic-radio">
                                    <label for="input-web-lock-yes">开启</label>
                                    <input type="radio" id="input-web-lock-no" name="g_web_lock" value="0" class="magic-radio">
                                    <label for="input-web-lock-no">关闭</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputWebText">网站关闭提示</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="网站关闭提示" name="g_web_text" id="inputWebText" class="form-control" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" >直属会员注册</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <input type="radio" id="input-sub-user-yes" checked name="g_sub_user" value="1" class="magic-radio">
                                    <label for="input-sub-user-yes">开启</label>
                                    <input type="radio" id="input-sub-user-no" name="g_sub_user" value="0" class="magic-radio">
                                    <label for="input-sub-user-no">关闭</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" >自动补货限制</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <input type="radio" id="input-auto-renew-yes" checked name="g_auto_renew" value="1" class="magic-radio">
                                    <label for="input-auto-renew-yes">开启</label>
                                    <input type="radio" id="input-auto-renew-no" name="g_auto_renew" value="0" class="magic-radio">
                                    <label for="input-auto-renew-no">关闭</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" >占成自由调整</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <input type="radio" id="input-rate-custom-yes" checked name="g_rate_custom" value="1" class="magic-radio">
                                    <label for="input-rate-custom-yes">开启</label>
                                    <input type="radio" id="input-rate-custom-no" name="g_rate_custom" value="0" class="magic-radio">
                                    <label for="input-rate-custom-no">关闭</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" >报表查询</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <input type="radio" id="input-report-yes" checked name="g_report" value="1" class="magic-radio">
                                    <label for="input-report-yes">开启</label>
                                    <input type="radio" id="input-report-no" name="g_report" value="0" class="magic-radio">
                                    <label for="input-report-no">关闭</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">即时注单</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <input type="radio" id="input-report-yes" checked name="g_order_now" value="1" class="magic-radio">
                                    <label for="input-ordernow-yes">开启</label>
                                    <input type="radio" id="input-ordernow-no" name="g_order_now" value="0" class="magic-radio">
                                    <label for="input-ordernow-no">关闭</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" >动态赔率</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <input type="radio" id="input-dynamic-odds-yes" checked name="g_dynamic_odds" value="1" class="magic-radio">
                                    <label for="input-dynamic-odds-yes">开启</label>
                                    <input type="radio" id="input-dynamic-odds-no" name="g_dynamic_odds" value="0" class="magic-radio">
                                    <label for="input-dynamic-odds-no">关闭</label>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            </div>
            <div class="col-sm-6">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-control">
                            <a class="btn btn-warning" id="config-save">
                                <i class="ion-document-text"></i> 保存
                            </a>
                        </div>
                        <h3 class="panel-title">其他配置</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{route('admin.config-store')}}" method="POST" id="config-form">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="inputMaxWin">单号最高限制</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="单号最高限制" name="g_max_win" id="inputMaxWin" class="form-control" autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="inputMinMoney">单注最低金额</label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="单注最低金额" name="g_min_money" id="inputMinMoney" class="form-control" autocomplete="false">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-control">
                            <a class="btn btn-warning" id="config-save">
                                <i class="ion-document-text"></i> 保存
                            </a>
                        </div>
                        <h3 class="panel-title">彩种设置</h3>
                    </div>
                    <div class="panel-body"></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-control">
                            <a class="btn btn-warning" id="config-save">
                                <i class="ion-document-text"></i> 保存
                            </a>
                        </div>
                        <h3 class="panel-title">特殊设置</h3>
                    </div>
                    <div class="panel-body"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/js/jquery.form.js"></script>
    <script>
        $(function () {
            $('#password-save').click(function () {
                $('#password-form').ajaxSubmit({
                    dataType:'json',
                    success: function (json) {
                        if(json.error_code==0){
                            $.niftyNoty({
                                type: 'success',
                                title: '密码更新成功',
                                message: '密码更新成功',
                                container: 'floating',
                                timer: 5000
                            });
                            location.reload();
                        }else {

                        }
                    },
                    error:function (data) {
                        var errors = data.responseJSON.errors;
                        var msg = [];
                        for(var i in errors){
                            msg.push(errors[i]);
                        }
                        $.niftyNoty({
                            type: 'danger',
                            title: '密码重置失败',
                            message: msg.join(','),
                            container: 'floating',
                            timer: 5000
                        });
                    }
                })
            });
        });
    </script>
@endsection
@extends('admin.base.main')
@section('content')
    <div id="page-content">
        <div class="row">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <a class="btn btn-warning" id="password-save">
                            <i class="ion-document-text"></i> 保存
                        </a>
                    </div>
                    <h3 class="panel-title">重置密码</h3>
                </div>
                <div class="panel-body">
                    <form action="{{route('admin.reset')}}" method="POST" id="password-form">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputOriginal">原密码</label>
                            <div class="col-sm-9">
                                <input type="password" placeholder="原密码" id="inputOriginal" class="form-control" name="original_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputPassword">新密码</label>
                            <div class="col-sm-9">
                                <input type="password" placeholder="新密码" id="inputPassword" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputPasswordConfirmation">确认密码</label>
                            <div class="col-sm-9">
                                <input type="password" placeholder="确认密码" id="inputPasswordConfirmation" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('js/jquery.form.js')}}"></script>
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
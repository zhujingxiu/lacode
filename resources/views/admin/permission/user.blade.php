@extends('admin.base.main')
@section('content')
<div id="page-content">
    <div class="row">
        <div class="col-sm-9">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">用户列表</h3>
                </div>

                <div class="panel-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>在线</th>
                            <th>名称</th>
                            <th>新增日期</th>
                            <th>功能</th>
                            <th>状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->online}}</td>
                                <td>{{$user->nick_name}}</td>
                                <td>{{$user->created_at}}</td>
                                <td></td>
                                <td>{{$user->status}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <a class="btn btn-warning" id="user-role-save">
                            <i class="ion-document-text"></i> 保存
                        </a>
                    </div>
                    <h3 class="panel-title">添加新{{$role->name}}</h3>
                </div>
                <div class="panel-body">
                    <form id="user-role-form" method="post" class="form-horizontal" action="{{route('admin.role-new-user')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="role" value="{{$role->code}}">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-name">{{$role->name}}账户</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{$role->name}}账户" name="name" id="input-name" class="form-control" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-nickname">{{$role->name}}名称</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="{{$role->name}}名称" name="nick_name" id="input-nickname" class="form-control" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-password">新密码</label>
                            <div class="col-sm-9">
                                <input type="password" placeholder="新密码" name="password" id="input-password" class="form-control" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input-share">状态</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <input type="radio" id="input-status-yes" checked name="status" value="1" class="magic-radio">
                                    <label for="input-status-yes">激活</label>
                                    <input type="radio" id="input-status-" name="status" value="-1" class="magic-radio">
                                    <label for="input-status-">冻结</label>
                                    <input type="radio" id="input-status-no" name="status" value="0" class="magic-radio">
                                    <label for="input-status-no">停用</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('script')
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script>
        $(function () {
            $('#user-role-save').click(function () {
                $('#user-role-form').ajaxSubmit({
                        dataType:'json',
                        success: function (json) {
                            if(json.error_code==0){
                                $.niftyNoty({
                                    type: 'success',
                                    title: '添加用户成功',
                                    message: json.msg,
                                    container: 'floating',
                                    timer: 3000
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
                                title: '用户保存失败',
                                message: msg.join(','),
                                container: 'floating',
                                timer: 5000
                            });
                        }
                    }
                );

            })
        });


    </script>
@endsection

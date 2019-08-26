@extends('admin.base.main')
@section('content')
<div id="page-content">
    <div class="row">
        <div class="col-sm-5">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">角色列表</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline" action="{{route('admin.role-store')}}">
                        <div class="form-group">
                            <label for="demo-inline-inputmail" class="sr-only">角色名称</label>
                            <input type="text" name="name" placeholder="角色名称" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="demo-inline-inputpass" class="sr-only">角色标识</label>
                            <input type="text" name="code" placeholder="角色标识" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="ion-plus-circled"></i> 创建角色</button>
                    </form>

                </div>
                <div class="panel-body">

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>类别</th>
                            <th>角色</th>
                            <th>标识</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $item)
                        <tr>
                            <td><a>{{ucwords($item['role'])}}</a></td>
                            <td><a class="btn-link">{{$item['title']}}</a></td>
                            <td>{{$item['code']}}</td>
                            <td>
                                <a class="btn btn-info btn-edit" data-link="{{route('admin.role-permissions', $item['id'])}}">
                                    <i class="ion-gear-a"></i> 配置</a>
                                @if(!$item['is_system'])
                                <a class="btn btn-danger btn-delete">
                                    <i class="ion-trash-a"></i> 删除</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <form method="POST" class="form-inline" id="permission-role-form">
                {{csrf_field()}}
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <a class="btn btn-warning" id="permission-role-save">
                            <i class="ion-document-text"></i> 保存
                        </a>
                    </div>
                    <h3 class="panel-title">角色权限配置</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label class="sr-only">类型</label>
                        <input type="text" placeholder="类型" name="form_role" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label class="sr-only">角色</label>
                        <input type="text" placeholder="角色" name="form_title" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label class="sr-only">标识</label>
                        <input type="text" placeholder="标识" name="form_code" class="form-control" readonly>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="permissions" class="col-sm-12"></div>
                </div>
            </div>
            </form>
        </div>
    </div>

</div>
@endsection
@section('script')
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script>
        $(function () {
            $('.btn-edit').click(function () {
                var url = $(this).data('link');
                $.getJSON(url,{_t:Math.random()}, function (json) {
                    if(json.error_code>0){
                        $.niftyNoty({
                            type: 'danger',
                            title: json.title,
                            message: '同步路由获取失败',
                            container: 'floating',
                            timer: 5000
                        });

                    }else{
                        var _role = json.data.role;
                        console.log(_role);
                        $('#permission-role-form').attr('action',_role.form_action);
                        $('#permission-role-form input[name="form_role"]').val(_role.title);
                        $('#permission-role-form input[name="form_title"]').val(_role.title);
                        $('#permission-role-form input[name="form_code"]').val(_role.code);
                        var _html = render_routes(json.data.permissions);
                        $('#permissions').html(_html)
                    }
                })
            });
            $('#permission-role-save').click(function () {
                $('#permission-role-form').ajaxSubmit({
                        dataType:'json',
                        success: function (json) {
                            if(json.error_code==0){
                                $.niftyNoty({
                                    type: 'success',
                                    title: json.title,
                                    message: '权限节点更新成功',
                                    container: 'floating',
                                    timer: 5000
                                });
                                location.reload();
                            }else {
                                $.niftyNoty({
                                    type: 'danger',
                                    title: json.title,
                                    message: '权限节点更新失败',
                                    container: 'floating',
                                    timer: 5000
                                });
                            }
                        }
                    }
                );

            })
        });

        function render_routes(nodes) {
            var _html = '';
            for(var item in nodes){
                var _controller = nodes[item];
                _html += '<div class="form-group"><ul class="list-unstyled">';
                _html += '<li class="col-xs-12"><p class="bg-info text-bold pad-all">控制器:'+item+'</p></li>';

                for(var i in _controller) {
                    var _route = _controller[i];
                    _html += '<li class="col-xs-6">';
                    _html += '<input id="perm-'+_route['id']+'" type="checkbox" class="magic-checkbox" value="'+ _route['id']+'" name="permissions[]" '+(_route['selected'] ? 'checked' : '')+'>';
                    _html += '<label for="perm-'+_route['id']+'">'+_route['title']+'</label>';
                    _html += '</li>';
                }
                _html +='</ul></div>'
            }
            return _html;
        }
    </script>
@endsection


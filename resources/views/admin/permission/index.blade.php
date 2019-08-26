@extends('admin.base.main')
@section('content')
<div id="page-content">

    <div class="row">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control">
                    <a class="btn btn-warning permission-save" data-value="1">
                        <i class="ion-document-text"></i> 保存
                    </a>
                </div>
                <h3 class="panel-title">已存储权限列表</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <form id="stored-form" method="POST">
                    <div id="stored-routes">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control">
                    <a class="btn btn-default" id="unstored-refresh">
                        <i class="demo-psi-repeat-2 icon-fw"></i> 同步刷新
                    </a>
                    <a class="btn btn-warning permission-save" data-value="0">
                        <i class="ion-document-text"></i> 保存
                    </a>
                </div>
                <h3 class="panel-title">待新建权限列表</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <form id="unstored-form" method="POST">
                    <div id="new-routes">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function () {
        get_routes('stored', 'stored-routes');
        $('#unstored-refresh').click(function () {
            get_routes('unstored', 'new-routes');
        });
        $('.permission-save').click(function () {
            var _val =$(this).data('value');
            var _form = $('#' + (_val ? 'stored-form' : 'unstored-form'));
            $.post('{{route('admin.permission-store')}}',
                {_token:'{{csrf_token()}}', stored:_val, permission:_form.serialize()}, function (json) {
                if(json.error_code==0){
                    $.niftyNoty({
                        type: 'success',
                        title: json.title,
                        message: json.msg,
                        container: 'floating',
                        timer: 5000
                    });
                    location.reload();
                }else {
                    $.niftyNoty({
                        type: 'danger',
                        title: json.title,
                        message: json.msg,
                        container: 'floating',
                        timer: 5000
                    });
                }
            },'json');
        });
    });



    function get_routes(mode, container) {
        $.getJSON('{{route('admin.ajax-routes')}}',{'mode':mode,_t:Math.random()},function (json) {
            if(json.error_code!=0){
                $.niftyNoty({
                    type: 'danger',
                    title: '同步获取失败',
                    message: '同步路由获取失败',
                    container: 'floating',
                    timer: 5000
                });
            }
            var _html = render_routes(json.data.permissions);
            $('#'+container).append(_html);
        });
    }

    function render_routes(nodes) {
        var num=1;
        var _html = '';
        for(var item in nodes){
            var _controller = nodes[item];
            _html += '<div class="form-group"><table class="table table-striped">';
            _html += '<caption><p class="text-bold bg-info pad-all">控制器:'+item+'</p></caption>';
            _html += '<thead><tr>';
            _html += '<td></td>';
            _html += '<td>分类</td>';
            _html += '<td>名称</td>';
            _html += '<td>请求</td>';
            _html += '<td>方法</td>';
            _html += '<td>URI</td>';
            _html += '<td>验证</td>';
            _html += '<td>记录</td>';
            _html += '<td>状态</td>';
            _html += '<td></td>';
            _html += '</tr></thead>';
            _html += '<tbody>';
            for(var i in _controller) {
                var _route = _controller[i];
                console.log(_route['role'])
                _html += '<tr>';
                _html += '<td>' + (num) + '<input type="hidden" name="perm[' +num+'][parent]" value="'+ item +'"></td>';
                _html += '<td><select class="form-control" name="perm[' + num + '][role]">';
                _html += '<option value="admin" '+( _route['role'] == 'admin' ? 'selected' : '')+'>Admin</option>';
                _html += '<option value="merchant" '+( _route['role'] == 'merchant' ? 'selected' : '')+'>Merchant</option>';
                _html += '</select></td>';
                _html += '<td><input type="text" class="form-control" name="perm[' + num + '][title]" value="'+(_route.hasOwnProperty('title') ? _route['title'] : '')+'"></td>';
                _html += '<td><input type="text" class="form-control" style="width: 60px" name="perm[' + num + '][method]" value="' + _route['method'] + '"></td>';
                _html += '<td><input type="text" class="form-control" style="width: 99px" name="perm[' + num + '][action]" value="' + _route['action'] + '"></td>';
                _html += '<td><input type="text" class="form-control" style="width: 199px" name="perm[' + num + '][path]" value="' + _route['path'] + '"></td>';
                _html += '<td><input id="node-auth-'+num+'" type="checkbox" class="magic-checkbox" name="perm[' + num + '][auth]" value="1" '+(( !_route.hasOwnProperty('auth') || _route['auth'] == 1) ? 'checked' : '')+'>';
                _html += '<label for="node-auth-'+num+'">是</label></td>';
                _html += '<td><input id="node-log-'+num+'" type="checkbox" class="magic-checkbox" name="perm[' + num + '][log]" value="1" '+((!_route.hasOwnProperty('log') || _route['log'] == 0) ? '' : 'checked')+'>';
                _html += '<label for="node-log-'+num+'">是</label></td>';
                _html += '<td><input id="node-status-'+num+'" type="checkbox" class="magic-checkbox" name="perm[' + num + '][status]" value="1" '+((!_route.hasOwnProperty('status') || _route['status'] == 1) ? 'checked' : '')+'>';
                _html += '<label for="node-status-'+num+'">是</label></td>';
                _html += '<td><a class="btn btn-warning" onclick="$(this).parent().parent().remove()" title="删除"><i class="ion-trash-a"></i></a></td>';
                _html += '</tr>';
                num++;
            }
            _html +='</tbody></table></div>'
        }
        return _html;
    }
</script>

@endsection
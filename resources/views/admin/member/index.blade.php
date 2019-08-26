@extends('admin.base.main')
@section('content')
<div id="page-content">
    <div class="row">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">
                    <a class="btn btn-info" id="member-new" data-link="{{route('admin.member-new')}}">
                        <i class="ion-document-text"></i> 添加会员
                    </a>
                    <a class="btn btn-danger" id="member-disabled" data-link="{{route('admin.member-disabled')}}">
                        <i class="ion-document-text"></i> 禁用会员
                    </a>
                </div>
                <h3 class="panel-title">会员管理</h3>
            </div>
            <div class="panel-body">
                <form class="form-inline">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="input-group mar-btm">
                                <span class="input-group-addon">起始注册时间</span>
                                <input type="text" id="filter-joined" class="form-control date-pick" >
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="input-group mar-btm">
                                <span class="input-group-addon">会员账户</span>
                                <input type="text" id="filter-username" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <div class="input-group mar-btm">
                                <span class="input-group-addon">会员名称</span>
                                <input type="text" id="filter-nickname" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <div class="input-group mar-btm">
                                <span class="input-group-addon">当前状态</span>
                                <select class="form-control" id="filter-status">
                                    <option value="*"></option>
                                    <option value="1">启用</option>
                                    <option value="-1">冻结</option>
                                    <option value="0">禁用</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <a id="btn-filter" class="btn btn-info">搜索</a>
                    </div>
                </form>
                <table id="list-table" class="table table-striped">
                </table>
            </div>

        </div>
    </div>

</div>
@endsection

@section('script')
    <link rel="stylesheet" href="{{asset('themes/nifty/plugins/bootstrap-table/bootstrap-table.min.css')}}">
    <link rel="stylesheet" href="{{asset('themes/nifty/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <script src="{{asset('themes/nifty/plugins/bootstrap-table/bootstrap-table.min.js')}}"></script>
    <script src="{{asset('themes/nifty/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('themes/nifty/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script>
        var checkboxFormatter =function (value, row, index) {
            return '<input type="checkbox" class="magic-checkbox" id="merc-'+index+'" name="_selected[]" value="'+value+'"><label for="merc-'+index+'"></label>';
        };
        var statusFormatter =function (value, row, index) {
            var _html = '<select name="status['+row.mid+']" class="form-control">';
            _html +='<option value="1" '+(value==1 ? 'selected' : '')+'>启用</option>';
            _html +='<option value="-1" '+(value==0 ? 'selected' : '')+'>冻结</option>';
            _html +='<option value="0" '+(value==-1 ? 'selected' : '')+'>禁用</option>';
            _html +='</select>';
            return _html;
        };
        var onlineFormatter =function (value, row, index) {
            var _html = '<input type="checkbox" class="magic-checkbox" disabled id="online-'+row.mid+'" '+(value==1 ? 'checked' : '')+'>';
            _html +='<label for="online-"'+row.mid+'>是</label>';
            return _html ;
        };
        var operationFormatter =function (value, row, index) {
            var _html = '<a class="btn btn-info" href="'+row.rebate_link+'">退水</a>';
            _html +='<a class="btn btn-primary">修改</a>';
            _html +='<a class="btn btn-default">日志</a>';
            return _html ;
        };

        var render_table = function (el) {
            $(el).bootstrapTable({
                url: '{{route('admin.member-list')}}',
                method: 'get',
                toolbar: '#toolbar',
                striped: true,
                cache: false,
                pagination: true,
                sortable: true,
                sortOrder: "desc",
                sidePagination: "server",
                pageNumber:1,
                pageSize: 20,
                uniqueId: "mid",
                queryParams: function (params) {
                    return {
                        'startdate' : $('#filter-joined').val(),
                        'username' : $('#filter-username').val(),
                        'nickname' : $('#filter-nickname').val(),
                        'status' : $('#filter-status').val(),
                        limit: params.limit,    //页面大小
                        offset: params.offset,  //页码
                        sort: params.sort,      //排序列名
                        order: params.order     //排位命令（desc，asc）
                    }
                },
                columns: [
                    {
                        field: 'mid',
                        align : 'center',
                        valign : 'middle',
                        formatter:  checkboxFormatter,
                        title: '<input type="checkbox" class="magic-checkbox" id="_id-all"><label for="_id-all"></label>'
                    },
                    {
                        field: 'merchant_role',
                        align : 'center',
                        valign : 'middle',
                        sortable : true,
                        title: '会员类型'
                    },
                    {
                        field: 'merchant',
                        align : 'center',
                        valign : 'middle',
                        sortable : true,
                        title: '上级代理'
                    },
                    {
                        field: 'rate',
                        align : 'center',
                        valign : 'middle',
                        title: '占成'
                    },
                    {
                        field: 'name',
                        align : 'center',
                        valign : 'middle',
                        title: '会员账户'
                    },
                    {
                        field: 'nickname',
                        align : 'center',
                        valign : 'middle',
                        sortable : true,
                        title: '会员名称'
                    },


                    {
                        field: 'balance',
                        align : 'center',
                        valign : 'middle',
                        sortable : true,
                        title: '余额'
                    },
                    {
                        field: 'online',
                        align : 'center',
                        valign : 'middle',
                        sortable : true,
                        formatter:  onlineFormatter,
                        title: '在线'
                    },
                    {
                        field: 'status',
                        align : 'center',
                        valign : 'middle',
                        sortable : true,
                        formatter:  statusFormatter,
                        title: '状态'
                    },

                    {
                        field: 'joined',
                        align : 'center',
                        valign : 'middle',
                        sortable : true,
                        title: '新增日期'
                    },
                    {
                        field: 'roulette',
                        align : 'center',
                        valign : 'middle',
                        sortable : true,
                        title: '盘口'
                    },
                    {
                        field: 'operation',
                        valign : 'middle',
                        formatter: operationFormatter,
                        title: '功能'
                    }
                ]
            });
            $(el).delegate('#_id-all','click',function () {
                var clicked = $(this).prop('checked');
                $.each($(this).parentsUntil('table').parent().find('input[name^="_selected"]'), function () {
                    $(this).prop('checked', clicked)
                })
            });
        }
        $(function () {
            render_table('#list-table');
            $('.date-pick').datepicker({
                format:'yyyy-mm-dd'
            })
            $('#btn-filter').bind('click',function () {
                $('#list-table').bootstrapTable('refresh');
            });
            $('#member-disabled').click(function () {
                var _url = $(this).data('link');
                var _selected = [];
                $.each($(this).parentsUntil('table').parent().find('input[name^="_selected"]:checked'), function () {
                    _selected.push($(this).val())
                });
                if(_selected.length>0){
                    $.getJSON(_url,{_t:Math.random(),'members':_selected.join(',')},function(){

                    })
                }else{
                    layer.msg('请至少选择一项',{icon:5});
                    return false;
                }
            });
            $('#member-grant').click(function () {
                var _url = $(this).data('link');
                var _selected = [];
                $.each($(this).parentsUntil('table').parent().find('input[name^="_selected"]:checked'), function () {
                    _selected.push($(this).val())
                });
                if(_selected.length>0){
                    $.getJSON(_url,{_t:Math.random(),selected:_selected},function (json) {
                        if(json.error_code>0){
                            $.niftyNoty({
                                type:  'danger',
                                title: json.title,
                                message: json.msg,
                                container: 'floating',
                                timer: 5000
                            });
                        }else{
                            layer.open({
                                title: json.data.title,
                                content: json.data.tpl,
                                area: '880px',
                                offset: '100px',
                                btn: ['保存', '关闭'],
                                yes:function () {
                                    $('#member-game-form').submit();
                                }
                            });
                        }
                    })
                }else{
                    layer.msg('请至少选择一项',{icon:5});
                    return false;
                }
            });
            $('#member-new').click(function () {
                var url = $(this).data('link');
                $.getJSON(url,{_t:Math.random()}, function (json) {
                    if(json.error_code>0){
                        $.niftyNoty({
                            type:  'danger',
                            title: json.title,
                            message: json.msg,
                            container: 'floating',
                            timer: 5000
                        });
                    }else if(json.data.tpl){
                        layer.open({
                            title: json.data.title,
                            content: json.data.tpl,
                            area: '880px',
                            offset: '100px',
                            btn: ['保存', '关闭'],
                            yes:function () {
                                $('#member-form').submit();
                            }
                        });
                    }else{
                        $.niftyNoty({
                            type: 'success',
                            title: json.title,
                            message: json.msg,
                            container: 'floating',
                            timer:  3000
                        });
                        location.reload()
                    }
                })
            })

        });
    </script>
@endsection
@extends('admin.base.main')
@section('content')
<!--===================================================-->
<div id="page-content">

    <div class="row">
        <div class="col-xs-2">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">在线分类统计</h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="badge badge-primary">20</span>管理
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-warning">20</span>分公司
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-primary">20</span>股东
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">11</span>总代理
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">11</span>代理
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-success">11</span>会员
                        </li>
                        <li class="list-group-item">
                            <span class="badge badge-info">11</span>子帐号
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-10">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">当前在线用户</h3>
                </div>

                <!--Data Table-->
                <!--===================================================-->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">账号</th>
                                <th class="text-center">名称</th>
                                <th class="text-center">可用金额</th>
                                <th class="text-center">下注金额</th>
                                <th class="text-center">今天输赢</th>
                                <th class="text-center">刷新时间</th>
                                <th class="text-center">IP</th>
                                <th class="text-center">IP归属</th>
                                <th class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><a href="#" class="btn-link"> Order #53431</a></td>
                                <td>Steve N. Horton</td>
                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 22, 2014</span></td>
                                <td>$45.00</td>
                                <td class="text-center">
                                    <div class="label label-table label-success">Paid</div>
                                </td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="btn-link"> Order #53432</a></td>
                                <td>Charles S Boyle</td>
                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 24, 2014</span></td>
                                <td>$245.30</td>
                                <td class="text-center">
                                    <div class="label label-table label-info">Shipped</div>
                                </td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089734531</td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089734531</td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089734531</td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089734531</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="btn-link"> Order #53433</a></td>
                                <td>Lucy Doe</td>
                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 24, 2014</span></td>
                                <td>$38.00</td>
                                <td class="text-center">
                                    <div class="label label-table label-info">Shipped</div>
                                </td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089934571</td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089934571</td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089934571</td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089934571</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="btn-link"> Order #53434</a></td>
                                <td>Teresa L. Doe</td>
                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 15, 2014</span></td>
                                <td>$77.99</td>
                                <td class="text-center">
                                    <div class="label label-table label-info">Shipped</div>
                                </td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089734574</td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089734574</td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089734574</td>
                                <td class="text-center"><i class="fa fa-plane"></i> CGX0089734574</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="btn-link"> Order #53435</a></td>
                                <td>Teresa L. Doe</td>
                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 12, 2014</span></td>
                                <td>$18.00</td>
                                <td class="text-center">
                                    <div class="label label-table label-success">Paid</div>
                                </td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="btn-link">Order #53437</a></td>
                                <td>Charles S Boyle</td>
                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 17, 2014</span></td>
                                <td>$658.00</td>
                                <td class="text-center">
                                    <div class="label label-table label-danger">Refunded</div>
                                </td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                            </tr>
                            <tr>
                                <td><a href="#" class="btn-link">Order #536584</a></td>
                                <td>Scott S. Calabrese</td>
                                <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 19, 2014</span></td>
                                <td>$45.58</td>
                                <td class="text-center">
                                    <div class="label label-table label-warning">Unpaid</div>
                                </td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="pull-right">
                        <ul class="pagination text-nowrap mar-no">
                            <li class="page-pre disabled">
                                <a href="#">&lt;</a>
                            </li>
                            <li class="page-number active">
                                <span>1</span>
                            </li>
                            <li class="page-number">
                                <a href="#">2</a>
                            </li>
                            <li class="page-number">
                                <a href="#">3</a>
                            </li>
                            <li>
                                <span>...</span>
                            </li>
                            <li class="page-number">
                                <a href="#">9</a>
                            </li>
                            <li class="page-next">
                                <a href="#">&gt;</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!--===================================================-->
                <!--End Data Table-->

            </div>
        </div>
    </div>



</div>
<!--===================================================-->
@endsection

@section('script')
    <!--Specify page [ SAMPLE ]-->
    {{--<script src="/nifty/js/demo/dashboard.js"></script>--}}
    <script>

        $(window).on('load', function() {

            // WELCOME NOTIFICATIONS
            // =================================================================
            // Require Admin Core Javascript
            // =================================================================
            $.niftyNoty({
                type: 'dark',
                title: 'Welcome Administrator.',
                message: 'You will notice that you now have an admin menu<br> that appears on the right hand side.',
                container: 'floating',
                timer: 5000
            });

        });

    </script>
@endsection
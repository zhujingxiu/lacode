<!--===================================================-->
<nav id="mainnav-container">
    <div id="mainnav">

        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">

                    <ul id="mainnav-menu" class="list-group">
                        <!--Menu list item-->
                        <li class="active-link">
                            <a href="{{route('admin.home')}}">
                                <i class="demo-psi-home"></i>
                                <span class="menu-title">
												<strong>Dashboard</strong>
											</span>
                            </a>
                        </li>

                        <!--Menu list item-->
                        <li>
                            <a href="#">
                                <i class="ion-person-stalker"></i>
                                <span class="menu-title">
                                    <strong>商户管理</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="{{route('admin.merchant-users','company')}}">分公司</a></li>
                                <li><a href="{{route('admin.merchant-users','shareholder')}}">股东</a></li>
                                <li><a href="{{route('admin.merchant-users','agent')}}">总代理</a></li>
                                <li><a href="{{route('admin.merchant-users','proxy')}}">代理</a></li>
                                <li class="list-divider"></li>
                                <li><a href="{{route('admin.merchant-users','admin')}}">管理员</a></li>

                            </ul>
                        </li>
                        <li class="active-link">
                            <a href="{{route('admin.member')}}">
                                <i class="ion-jet"></i>
                                <span class="menu-title">
                                    <strong>会员管理</strong>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="ion-cube"></i>
                                <span class="menu-title">
												<strong>权限管理</strong>
											</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="{{route('admin.permission')}}">权限节点</a></li>
                                <li><a href="{{route('admin.role')}}">角色管理</a></li>

                            </ul>
                        </li>
                        <li class="list-divider"></li>

                        <li>
                            <a href="{{route('admin.games')}}">
                                <i class="ion-aperture"></i>
                                <span class="menu-title">彩种管理</span>
                            </a>
                        </li>
                        <!--Menu list item-->
                        <li>
                            <a href="{{route('admin.config')}}">
                                <i class="ion-settings"></i>
                                <span class="menu-title">系统设置</span>
                            </a>
                        </li>


                        <!--Menu list item-->
                        <li>
                            <a href="#">
                                <i class="demo-psi-receipt-4"></i>
                                <span class="menu-title">注单管理</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="tables-static.html">Static Tables</a></li>
                                <li><a href="tables-bootstrap.html">Bootstrap Tables</a></li>
                                <li><a href="tables-datatable.html">Data Tables</a></li>
                                <li><a href="tables-footable.html">Foo Tables</a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="helper-classes.html">
                                <i class="demo-psi-inbox-full"></i>
                                <span class="menu-title">公告管理</span>
                            </a>
                        </li>
                        <li class="list-divider"></li>

                        <!--Category name-->
                        <li class="list-header">统计报表</li>

                        <!--Menu list item-->
                        <li>
                            <a href="{{route('admin.online')}}">
                                <i class="ion-bonfire"></i>
                                <span class="menu-title">在线统计</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="demo-psi-bar-chart"></i>
                                <span class="menu-title">报表查询</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="misc-timeline.html">Timeline</a></li>
                                <li><a href="misc-calendar.html">Calendar</a></li>
                                <li><a href="misc-maps.html">Google Maps</a></li>

                            </ul>
                        </li>

                        <!--Menu list item-->
                        <li>
                            <a href="#">
                                <i class="ion-pricetags"></i>
                                <span class="menu-title">历史开奖</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="mailbox.html">Inbox</a></li>
                                <li><a href="mailbox-message.html">View Message</a></li>
                                <li><a href="mailbox-compose.html">Compose Message</a></li>
                                <li><a href="mailbox-templates.html">Email Templates<span class="label label-info pull-right">New</span></a></li>

                            </ul>
                        </li>

                    </ul>


                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
<!--===================================================-->
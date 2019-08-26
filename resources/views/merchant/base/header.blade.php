<header id="header-top" class="topBox">
    <table class="gridtable">
        <tbody>
        <tr>
            <td rowspan="2" width="195" height="63" style="background:'/img/merchant/logo.jpg'" >
                <div class="logoBox">永嘉</div>
            </td>
            <td height="22" valign="top">
                <div class="Righttop">
                    <marquee onmouseover="this.setAttribute('scrollamount', 0, 0);"
                             onmouseout="this.setAttribute('scrollamount', 2, 0);" direction="left" scrolldelay="4"
                             scrollamount="2" behavior="scroll">
                        <a href="News.htm" target="content"><span id="Affiche">hasjdksajk</span></a>
                    </marquee>
                </div>
            </td>
        </tr>
        <tr>
            <td height="41" valign="top">
                <div class="Rightbottom" style="width:900px">
                    <div class="left">
                        <ul class="navOne-new">
                            <li id="bankLi" class="czBtn">
                                <span id="currentType">请选择</span>
                            </li>
                        </ul>
                        <div class="navOne-newDown">
                            <div class="clearfix" id="bankLi-down" style="display: none; top: 32px;">
                                <ul>
                                    @php
                                        $merchant_games = Session::get(config('site.merchant_game_key'));
                                    @endphp
                                    @foreach($merchant_games as $game)
                                    <li class="pullGroup" data-group="{{$game['id']}}"><a >{{$game['title']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="right">
                        <ul id="navBtnMenu">
                            @php
                                $menus = Session::get(config('site.merchant_menu_key'));
                            @endphp
                            @foreach($menus as $menu)

                            <li data-menu="{{$menu['id']}}" class="{{$menu['style']}} {{$loop->first? 'navBtn1' : ($loop->last? 'navBtn3' :'navBtn2' )}}" >
                                @if(count($menu['children']))
                                    {{$menu['title']}}
                                    @else
                                    <a data-pjax="true" href="{{$menu['path']}}">{{$menu['title']}}</a>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div style="width:1450px;/* float:left */">
        <div class="userBox">管理員：admin</div><!--显示当前用户-->
        <div id="navListBox" class="navListBox">
            @foreach($menus as $menu)
                @if(count($menu['children']))
                    <div id="menu-children-{{$menu['id']}}" class="menu-children" style="display: none">
                    @foreach($menu['children'] as $child)
                            <a data-pjax="true" href="{{$child['path']}}">{{$child['title']}}</a> {{$loop->last ? '' : '|'}}
                        @endforeach
                    </div>
                    @endif
                @endforeach
                @foreach($merchant_games as $game)
                    @if(count($game['groups']))
                        <div id="group-children-{{$game['id']}}" class="menu-children" style="display: none">
                            @foreach($game['groups'] as $child)
                                <a data-pjax="true" href="{{route('merchant.order-bet', $child['id'])}}">{{$child['title']}}</a> {{$loop->last ? '' : '|'}}
                            @endforeach
                        </div>
                    @endif
                @endforeach

        </div>
    </div>
    <div class="clear"></div>
</header>
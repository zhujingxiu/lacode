<div class="topBox" id="appHead">
    <table class="gridtable">
        <tbody>
        <tr>
            <td rowspan="2" width="231" height="59" background="{{asset('img/member/logo.gif')}}">
                <div class="logoBox" v-text="title"></div>
            </td>
            <td>
                <div class="Righttop">
                    <marquee onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 2, 0);" direction="left" scrolldelay="4" scrollamount="2" behavior="scroll">
                        <span id="Affiche" v-text="notice"></span>
                    </marquee>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="Rightbottom">
                    <div class="left">
                        <ul class="navOne-new" v-on:mouseover="gameHover=true" v-on:mouseout="gameHover=false">
                            <li id="bankLi" name="bankLi" class="czBtn" v-text="game_selected.title"></li>
                        </ul>

                        <div class="navOne-newDown" v-on:mouseover="gameHover=true" v-on:mouseout="gameHover=false">
                            <div class="clearfix" id="bankLi-down" v-show="gameHover">
                                <ul>
                                    <li v-for="item in games">
                                        <a v-on:click="gameSelected(item.id)" v-text="item.title"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="right">
                        <ul id="navBtnMenu">

                            <li id="liBtn0" class="navBtn" onclick="topMenu()">信用資料</li>
                            <li id="liBtn1" class="navBtn" onclick="upPwd()">修改密碼</li>
                            <li id="liBtn2" class="navBtn" onclick="report()">未結明細</li>
                            <li id="liBtn3" class="navBtn" onclick="resut()">今天已結</li>
                            <!--<li id="liBtn4" class="navBtn" onclick="report()">下注明細</li>-->
                            <li id="liBtn5" class="navBtn" onclick="repore()">結算報表</li>
                            <li id="liBtn6" class="navBtn" onclick="result()">歷史開獎</li>
                            <li id="liBtn7" class="navBtn" onclick="rule()">玩法規則</li>
                            <li id="liBtn8" class="navBtn" href="{{route('member.logout')}}">安全退出</li>

                        </ul>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </td>
        </tr>
        </tbody></table>
    <div style="width:1010px; float:left">
        <div class="userBox">請檢視您以下的賬戶信息</div>

        <!--这里插入连接-->
        <div class="navListBox" id="Type_List">
            <a href="javascript:void(0)"
               v-for="(item, index) in game_selected.groups"
               v-bind:class="item.id==selected_group_id ? 'groupSelected' : '' "
               v-text="item.title"
               v-on:click="groupSelected(index)"></a>
        </div>
    </div>
    <div class="clear"></div>
</div>
<script>
    new Vue({
        el: '#appHead',
        data: {
            title:'永嘉',
            notice: '',
            gameHover:false,
            games:{},
            selected_game_id: 0,
            selected_group_id: 0,
            game_selected :{'id':'','title':'', 'groups':[]}
        },
        created:function () {
            this.loadNotice();
            this.loadGames();
        },
        methods:{
            loadNotice:function () {
                var vm = this;
                axios.get('{{route('member.notice')}}')
                    .then(function (response) {
                        var json= response.data;
                        vm.notice = json.data.notice.content
                    })
                    .catch(function (error) {
                        vm.notice = 'Error! Could not reach the API. ' + error
                    })
            },
            loadGames:function () {
                var vm = this;
                axios.get('{{route('member.games')}}')
                    .then(function (response) {
                        var json= response.data;
                        var games = json.data.games;
                        for(i in games){
                            var _game = games[i];
                            vm.games[_game.game_id] = {
                                'id': _game.game_id,
                                'title': _game.game.title,
                                'groups':_game.game.groups
                            };
                            if(vm.selected_game_id==0){
                                vm.selected_game_id = _game.game_id;
                                vm.gameSelected(vm.selected_game_id);
                            }
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            gameSelected:function (game_id) {
                this.game_selected = this.games[game_id];
                this.groupSelected(0)
            },
            groupSelected:function (index) {
                var group = this.game_selected.groups[index];
                this.selected_group_id = group.id;
                var vm = this;
                axios.get('{{route('member.group')}}',{
                    params: {
                        group: group.id
                    }
                }).then(function (response) {
                        var json= response.data;
                        var tpl = json.data.tpl;
                        $('#page-content').html(tpl)
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            }
        }

    });
</script>
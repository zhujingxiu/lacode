<template>
    <div class="topBox">
        <table class="gridtable">
            <tbody>
            <tr>
                <td rowspan="2" width="231" height="59" class="logotd">
                    <div class="logoBox" >{{siteTile}}</div>
                </td>
                <td>
                    <div class="Righttop">
                        <marquee onmouseover="this.setAttribute('scrollamount', 0, 0);" onmouseout="this.setAttribute('scrollamount', 2, 0);" direction="left" scrolldelay="4" scrollamount="2" behavior="scroll">
                            <span id="Affiche" >{{notice}}</span>
                        </marquee>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="Rightbottom">
                        <div class="left">
                            <ul class="navOne-new" v-on:mouseover="gamesHover=true" v-on:mouseout="gamesHover=false">
                                <li id="bankLi" class="czBtn">{{game_selected.title}}</li>
                            </ul>

                            <div class="navOne-newDown" v-on:mouseover="gamesHover=true" v-on:mouseout="gamesHover=false">
                                <div class="clearfix" id="bankLi-down" v-show="gamesHover">
                                    <ul>
                                        <li v-for="(item, index) in games" :key="index" :id="'game-'+item.id">
                                            <a v-on:click="gameSelected(item.id)" href="javascript:void(0)">{{item.title}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="right">
                            <ul id="navBtnMenu">

                                <li id="liBtn0" class="navBtn" onclick="topMenu()">信用資料</li>
                                <li id="liBtn1" class="navBtn">
                                    <router-link to="/reset">修改密碼</router-link>
                                </li>
                                <li id="liBtn2" class="navBtn" onclick="report()">未結明細</li>
                                <li id="liBtn3" class="navBtn" onclick="resut()">今天已結</li>
                                <!--<li id="liBtn4" class="navBtn" onclick="report()">下注明細</li>-->
                                <li id="liBtn5" class="navBtn" onclick="repore()">結算報表</li>
                                <li id="liBtn6" class="navBtn" onclick="result()">歷史開獎</li>
                                <li id="liBtn7" class="navBtn">
                                    <router-link to="/rule">玩法規則</router-link>
                                </li>
                                <li id="liBtn8" class="navBtn">
                                    <router-link to="/logout">安全退出</router-link>
                                </li>

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

            <div class="navListBox" id="Type_List">
                <router-link v-for="(group,index) in game_selected.groups"
                             :to="{name:'group',params:{groupId:group.id}}"
                             :key="index">
                    {{group.title}}
                </router-link>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</template>


<script>
    export default {
        name: "VHeader",
        data() {
            return {
                siteTile:'永嘉',
                notice: '',
                gamesHover:false,
                games:[],
                game_selected :{'id':0,'title':'','groups':{}}
            }
        },
        created:function () {
            this.loadNotice();
            this.loadGames();

        },
        methods:{
            loadNotice:function () {
                var vm = this;
                axios.get('/notice')
                    .then(function (response) {
                        var json= response.data;
                        vm.notice = json.data.content
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            loadGames:function () {
                var vm = this;
                axios.get('/games')
                    .then(function (response) {
                        var json= response.data;
                        vm.games = json.data.games;
                        if(vm.game_selected.id==0){
                            vm.gameSelected(1)
                        }
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            gameSelected:function (game_id) {
                this.game_selected = this.games[game_id];
            },
        }
    }
</script>

<style scoped>
    .navBtn > a{
        text-underline: none !important;
        color: #fff;
    }
    .logotd{
        background: url('/img/member/logo.gif');
    }
    .navListBox .router-link-active{
        color: #FF0000 !important;
    }
</style>
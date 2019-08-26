<template>
    <table class="th" border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td height="28px" class="bolds">{{game.title}}  &nbsp;  <span class="gameGroup">{{group.title}}</span></td>

            <td class="dayProfit">今天輸贏：<span id="sy" class="shuyingjieguo2">0.0</span></td>
            <td class="lastLottery">
                <span id="number">{{lastIssue}}</span> 期賽果
            </td>
            <td width="24" v-for="noValue in lastNmbers" :class="game.no_style+noValue"></td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "Last",
        props:['game','group','reloadLast','lastIssue'],
        data(){
            return {
                lastNmbers: {},
            }
        },
        watch:{
            game: function(){
                this.loadLast();
            },
            reloadLast(){
                if(this.reloadLast){
                    this.loadLast();
                }
            }
        },
        methods: {
            loadLast: function () {
                var vm = this;
                axios.get('/last', {
                    params: {
                        game: vm.game.id
                    }
                }).then(function (response) {
                    var json = response.data;
                    vm.lastNmbers = json.data.numbers;
                    vm.$emit('setLastIssue', json.data.issue);
                    vm.$emit('reloadLastSwitch', false);

                })
                .catch(function (error) {
                    console.log(error);
                })
            },
        }
    }
</script>

<style scoped>
    .lastLottery{
        text-align: right;
        padding-right: 10px;
        font-weight: bold;
    }
    .gameGroup{
        color:#0033FF; font-weight:bold;
    }
    .dayProfit{
        color:red;font-weight: bold;
    }
</style>
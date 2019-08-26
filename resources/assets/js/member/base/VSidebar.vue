<template>
    <div id="sidebar">
    <table border="0" cellpadding="0" cellspacing="1" class="t_list" >
        <tbody>
        <tr>
            <td class="t_td_caption_1" width="66">會員帳戶</td>
            <td class="t_td_text" width="165" v-text="username"></td>
        </tr>


        <tr>
            <td class="t_td_caption_1">盤　　口</td>
            <td class="t_td_text" v-text="roulette"></td>
        </tr>

        <tr >
            <td class="t_td_caption_1">信用額度</td>
            <td class="t_td_text" v-text="credit"></td>
        </tr>
        <tr>
            <td class="t_td_caption_1">可用金額</td>
            <td id="currentCredits" class="t_td_text">
                <span id="jine1111" v-text="balance"></span>&nbsp;&nbsp;
                <button type="button" id="flush" v-on:click="loadBalance">刷新</button>
            </td>
        </tr>


        <!--投註成功-->
        <tr>
            <td class="t_list_caption" colspan="2">
                <a target="_blank" href="http://b111c.com/html/shishicai_cq/ssc_index.html" onclick="'#','重慶時時彩','width=488,height=183,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no,location=no';"> “重慶時時彩”開獎网</a>&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td class="t_list_caption" colspan="2">
                <a target="_blank" href="http://b111c.com/html/shishicai_jisu/ssc_index.html" onclick="'#','極速時時彩','width=488,height=183,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no,location=no';"> “極速時時彩”開獎网</a>&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td class="t_list_caption" colspan="2">
                <a target="_blank" href="http://b111c.com/html/PK10/pk10kai.html" onclick="'#','北京賽車','width=687,height=464,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no,location=no';"> “北京赛车PK10”開獎网</a>&nbsp;&nbsp;
            </td>
        </tr>
        <tr>
            <td class="t_list_caption" colspan="2">
                <a href="javascript:void(0);" onclick="'#','幸运飞艇','width=687,height=464,directories=no,status=no,scrollbars=yes,resizable=yes,menubar=no,toolbar=no,location=no';"> “幸运飞艇”開獎网</a>&nbsp;&nbsp;
            </td>
        </tr>
        </tbody>
    </table>
    </div>
</template>

<script>
    export default {
        name: "VSidebar",
        data(){
            return {
                username:'...',
                credit:'0',
                roulette:'...',
                balance:'0',
                _timer: null
            }
        },
        created:function () {
            this.loadProfile();
            let that = this;
            this._timer = setInterval(function(){
                that.loadBalance();
            },330000)
        },
        methods:{
            loadProfile:function(){
                var vm = this;
                axios.get('/profile')
                    .then(function (response) {
                        var json= response.data;
                        vm.username = json.data.username;
                        vm.credit = json.data.credit;
                        vm.roulette = json.data.roulette+'盤';
                        vm.balance = json.data.balance;
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            loadBalance:function () {
                this.balance = '加载中';
                var vm = this;
                axios.get('/balance')
                    .then(function (response) {
                        var json= response.data;
                        vm.balance = json.data.balance
                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            }
        }
    }
</script>

<style scoped>

</style>
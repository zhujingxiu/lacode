<template>
    <div>
        <table border="0" width="700" style="margin-top:8px;">
            <tbody>
            <tr height="30">
                <td align="center" colspan="7">
                    <a class="font_g F_bold quickBuy" title="快捷下註" @click="toggleQuick" >
                        <input id="quickChecked" v-model="quickChecked" type="checkbox"> 快捷下注
                    </a>
                    <a title="快捷下註使用說明" class="font_r" @click="quickNote" style="color:#FF0000">說明</a>
                    <span style="color:#299a26">金額：</span>
                    <input name="moneyHelper"  type="text" size="7" maxlength="20" class="inp1m"
                           v-validate="{max:7,numeric:true}" data-vv-as="快捷下注"
                           v-model="help_money">
                    <input type="button" class="inputs ti" value="下註" @click="bettingNow" >
                    <input type="button" class="inputs ti" value="重填" @click="clearMoney">
                    <input type="button" class="inputs ti" value="取消选中" @click="clearSelected">
                </td>
            </tr>
            <tr>
                <td align="center">
                    <div class="poker_50" @click="addMoney(50)" title="50"></div>
                </td>
                <td align="center">
                    <div class="poker_100" @click="addMoney(100)" title="100"></div>
                </td>
                <td align="center">
                    <div class="poker_500" @click="addMoney(500);" title="500"></div>
                </td>
                <td align="center">
                    <div class="poker_1000" @click="addMoney(1000);" title="1000"></div>
                </td>
                <td align="center">
                    <div class="poker_5000" @click="addMoney(5000);" title="5000"></div>
                </td>
                <td align="center">
                    <div class="poker_10000" @click="addMoney(10000);" title="10000"></div>
                </td>
            </tr>
            </tbody>
        </table>
        <ul>
            <li v-for="error in errors.all()">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "QuickBuy",
        props: ['quickChecked','quickMoney'],
        data(){
            return {
                help_money:'',
            }
        },
        watch:{
            help_money(){
                this.$emit('setQuickMoney', this.help_money)
            }
        },
        computed:{
            errors(){
                alert(typeof errors.all())
            }
        },
        methods:{
            toggleQuick(){
                this.$emit('setQuickChecked', !this.quickChecked)
            },
            quickNote(){
                alert('填入快捷金額后，只需鼠標點擊要下注項目對應的輸入框，系統將自動輸入預設金額來方便快速下注。');
            },
            addMoney(money){
                this.help_money = this.$parent.mathAdd(this.help_money,money);
            },
            clearMoney(){
                this.help_money = 0;
            },
            clearSelected(){
                return this.$parent.clearSelected()
            },
            bettingNow(){
                var form = this.$parent.$refs.formOrder;
                var formData = new FormData(form);
                console.log(form)
                axios.post('/betting',formData).then(function (response) {
                    var json = response.data;
                    console.log(json)
                }).catch(function (error) {
                    console.log(error)
                })
            }
        }
    }
</script>

<style scoped>
    .quickBuy{
        color:#299a26;text-decoration:none; font-weight:bold;
    }
    .poker_10, .poker_20, .poker_50, .poker_100, .poker_200, .poker_500, .poker_1000, .poker_2000, .poker_5000, .poker_10000, .poker_20000, .poker_50000 {
        width: 46px;
        height: 46px;
        background-image:url('/img/member/poker.png');
        background-repeat: no-repeat;
        margin: 0px auto;
        cursor: pointer;
    }
    .poker_10 {
        background-position: 0px 0px
    }
    .poker_20 {
        background-position: 0px -46px
    }
    .poker_50 {
        background-position: 0px -92px
    }
    .poker_100 {
        background-position: 0px -138px
    }
    .poker_200 {
        background-position: 0px -184px
    }
    .poker_500 {
        background-position: 0px -230px
    }
    .poker_1000 {
        background-position: 0px -276px
    }
    .poker_2000 {
        background-position: 0px -322px
    }
    .poker_5000 {
        background-position: 0px -368px
    }
    .poker_10000 {
        background-position: 0px -414px
    }
    .poker_20000 {
        background-position: 0px -460px
    }
    .poker_50000 {
        background-position: 0px -506px
    }
</style>
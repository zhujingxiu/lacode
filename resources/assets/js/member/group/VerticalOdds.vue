<template>
    <div>

        <table class="table" border="0" cellpadding="0" cellspacing="1" >
            <tbody>
            <template v-for="openingOdds in chunkOdds">
            <tr >
                <template v-if="openingOdds.length<3">
                    <td :colspan="chunk*3" class="toHorizontalTD">
                        <table  class="openingOdds" width="100%"  border="0" cellpadding="0" cellspacing="1"
                                v-for="(odds,option_id) in openingOdds" :key="option_id">
                            <tr class="t_list_caption">
                                <td :colspan="odds.max*3">{{odds.title}}{{odds.remark}}</td>
                            </tr>
                            <template v-for="bet_line in odds.bets" >
                                <tr class="t_td_text oddsTr">

                                    <template v-for="(bet, bet_id) in bet_line" >
                                        <template v-if="bet">
                                            <td v-if="bet.style" :class="['odds-'+option_id+'-'+bet_id,bet.style+bet.title, 'caption_1']" width="8%" @click="betSelected"></td>
                                            <td v-else width="8%" :class="['odds-'+option_id+'-'+bet_id,'caption_1']" @click="betSelectedHorizontal">{{bet.title}}</td>
                                            <td width="8%" :class="'odds-'+option_id+'-'+bet_id" @click="betSelectedHorizontal">
                                                {{bet.odds}}
                                                <input type="hidden" :name="'odd['+option_id+']['+bet_id+'][odds]'" :value="bet.odds">
                                            </td>
                                            <td :class="['odds-'+option_id+'-'+bet_id,'loads']">
                                                <span v-if="oddsLock" class="lockTxt">停押</span>
                                                <input type="text" class="inp1" v-if="!oddsLock" :option="'odds-'+option_id+'-'+bet_id"
                                                       :name="'odd['+option_id+']['+bet_id+'][money]'"
                                                       @focus="addSelected">
                                            </td>
                                        </template>
                                        <template v-else>
                                            <td colspan="3"></td>
                                        </template>
                                    </template>
                                </tr>
                            </template>
                        </table>
                    </td>
                </template>
                <template v-else>
                <td v-for="(odds,option_id) in openingOdds" :key="option_id" >

                    <table class="openingOdds" width="100%"  border="0" cellpadding="0" cellspacing="1">
                        <tr class="t_list_caption" style="color:#000">
                            <td colspan="3">{{odds.title}}{{odds.remark}}</td>
                        </tr>
                        <tr class="t_list_caption" style="color:#000">
                            <td>號</td>
                            <td>賠率</td>
                            <td>金額</td>
                        </tr>
                        <template v-for="bet_line in odds.bets" >
                            <tr class="t_td_text oddsTr" v-for="(bet, bet_id) in bet_line" @click="betSelected">
                                <td :class="['odds-'+odds.id+'-'+bet_id,bet.style+bet.title]" v-if="bet.style" width="33"></td>
                                <td :class="'odds-'+odds.id+'-'+bet_id" v-else width="33">{{bet.title}}</td>
                                <td width="45" :class="'odds-'+odds.id+'-'+bet_id">
                                    {{bet.odds}}
                                    <input type="hidden" :name="'odd['+odds.id+']['+bet_id+'][odds]'" :value="bet.odds">
                                </td>
                                <td :class="['odds-'+odds.id+'-'+bet_id,'loads']">
                                    <span v-if="oddsLock" class="lockTxt">停押</span>
                                    <input type="text" class="inp1" v-if="!oddsLock" :option="'odds-'+odds.id+'-'+bet_id"
                                           :name="'odd['+odds.id+']['+bet_id+'][money]'"
                                           @focus="addSelected">
                                </td>
                            </tr>
                        </template>
                    </table>
                </td>
                </template>
            </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "VerticalOdds",
        props:['openingOdds','oddsLock','quickMoney', 'quickChecked'],
        data(){
            return {
                'chunk':5
            }
        },
        watch:{
            quickMoney:function () {
                if(this.quickChecked){
                    var options = document.getElementsByClassName('_option_selected');
                    for(let i=0;i<options.length;i++){
                        var _input = options[i].getElementsByClassName('inp1')[0];
                        if(_input)
                            _input.value = Math.max(0, this.quickMoney)
                    }
                }
            }
        },
        computed:{
            chunkOdds:function () {
                var options = Object.keys(this.openingOdds);
                let n = this.chunk;
                var chunks = options.slice(0,(options.length+n-1)/n|0).map(function(c,i) {
                    return options.slice(n*i,n*i+n);
                });
                var tmp = [];
                for(let i in chunks){
                    var line = [];
                    for (let j in chunks[i]){
                        let _key = chunks[i][j];
                        line.push(this.openingOdds[_key])
                    }
                    tmp.push(line)
                }
                return tmp
            }
        },
        methods:{
            addSelected:function (event) {
                var $target = event.target;
                var ref_class = $target.getAttribute('option');
                if(this.quickChecked){
                    $target.value = this.quickMoney;
                }
                return this.$parent.optionSelected(ref_class);
            },
            betSelected:function (event) {
                var $taget = event.target.parentNode;
                if(this.$parent.hasClass(event.target,'_option_selected')){
                    var options = $taget.getElementsByClassName('_option_selected');
                    var elements = [];
                    for(let i in options){
                        elements[i] = options[i];
                    }
                    for(let i in elements){
                        this.$parent.delClass(elements[i],'_option_selected')
                    }
                }else {
                    var _input = $taget.getElementsByClassName('inp1')[0];
                    if (_input)
                        _input.dispatchEvent(new Event('focus'))
                }
            },
            betSelectedHorizontal:function (event) {
                var $target = this.$parent.nextnNode(event.target);
                var _input = $target.getElementsByClassName('inp1')[0];
                if(this.$parent.hasClass(event.target,'_option_selected')){
                    var ref_class = '';
                    if(_input){
                        ref_class = _input.getAttribute('option')
                    }else{
                        $target = this.$parent.nextnNode($target)
                        _input = $target.getElementsByClassName('inp1')[0];
                        if (_input){
                            ref_class = _input.getAttribute('option')
                        }
                    }
                    if(ref_class){
                        var options = document.getElementsByClassName(ref_class);
                        for(let i=0;i<options.length;i++){
                            this.$parent.delClass(options[i],'_option_selected')
                        }
                    }
                }else {

                    if (_input) {
                        _input.dispatchEvent(new Event('focus'))
                    } else {
                        $target = this.$parent.nextnNode($target)
                        _input = $target.getElementsByClassName('inp1')[0];
                        if (_input)
                            _input.dispatchEvent(new Event('focus'))
                    }
                }
            },
        }
    }
</script>

<style scoped>
    .table{
        width: 700px;
        margin-left: 12px;
        margin-bottom: 3px;
    }
    .openingOdds{
        background-color: #E9BA84;
    }
    .t_td_text {
        height: 27px;
        line-height: 17px;
        text-align: center;
        background-color: rgb(255, 255, 255);
    }
    .inp1 {
        background-position: -0px 0;
        color: #00f;
        width: 50px;
        height: 15px;
        background: #FFFFFF;
        font-weight: bold;
    }
    .inp1m{
        width:50px;
        height:15px;
        border:1px solid #A7BBD3;
        color:#000;
        border-color: #FF8800;
        background:#FCFDCF;
    }
    .caption_1 {
        background-color: rgb(253, 248, 242);
    }
    ._option_selected {
        background-color: #ffc214;
    }
    .lockTxt{
        color: red;
        font-weight: bold;
        display: inline-block;
        width: 50px;
    }
</style>
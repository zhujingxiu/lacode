<template>
    <div>
        <table class="table openingOdds" border="0" cellpadding="0" cellspacing="1" v-for="(odds,option_id) in openingOdds" :key="option_id">
            <tr class="t_list_caption" style="color:#000" v-if="odds.show">
                <td :colspan="odds.max*3">{{odds.title}}{{odds.remark}}</td>
            </tr>
            <template v-for="bet_line in odds.bets" >
                <tr class="t_td_text oddsTr">

                    <template v-for="(bet, bet_id) in bet_line" >
                        <template v-if="bet">
                            <td v-if="bet.style" :class="['odds-'+option_id+'-'+bet_id,bet.style+bet.title, 'caption_1']" width="8%" @click="betSelected"></td>
                            <td v-else width="8%" :class="['odds-'+option_id+'-'+bet_id,'caption_1']" @click="betSelected">{{bet.title}}</td>
                            <td width="8%" :class="'odds-'+option_id+'-'+bet_id" @click="betSelected">
                                {{bet.odds}}
                                <input type="hidden" :name="'odd['+option_id+']['+bet_id+'][odds]'" :value="bet.odds">
                            </td>
                            <td :class="['odds-'+option_id+'-'+bet_id,'loads']">
                                <span v-if="oddsLock" class="lockTxt">停押</span>
                                <input type="text" class="inp1" v-if="!oddsLock" :option="'odds-'+option_id+'-'+bet_id"
                                       :name="'odd['+option_id+']['+bet_id+'][money]'"
                                       v-validate="{max:6,numeric:true}"
                                       :data-vv-as="odds.title+'-'+bet.title"
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
    </div>
</template>

<script>
    export default {
        name: "HorizontalOdds",
        props:['issue','oddsLock','openingOdds','quickMoney', 'quickChecked'],

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

    input.valid {
        border-color: green;
    }

    input.isInvalid {
        border-color: red;
    }
</style>
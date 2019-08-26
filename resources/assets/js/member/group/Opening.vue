<template>
    <table class="table" border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td height="30" width="160px">
                <span class="openingIssue">{{issue}}</span> 期
            </td>
            <td>距離封盤：<span style="font-size:104%" id="endTime" :second="end_time">{{end_time|formatMinuteTime}}</span>
            </td>
            <td>
                距離開獎：<span style="color:red;font-size:104%" id="endTimes" :second="opening_time">{{opening_time|formatMinuteTime}}</span>
            </td>
            <td align="right">
                <span id="endTimea" :second="interval_time">{{interval_time}}</span> 秒
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "Opening",
        props:['game','issue','oddsLock'],
        data(){
            return {
                end_time: 0,
                _endTimer: null,
                opening_time: 0,
                _openingTimer: null,
                interval_time:0,
                _intervalTimer: null,
                half_reload: 0
            }
        },
        watch:{
            game: function(){
                this.loadOpening();
            }
        },
        beforeDestroy() {
            clearInterval(this._intervalTimer);
            clearInterval(this._openingTimer);
            clearInterval(this._endTimer);
            this._intervalTimer = null;
            this._openingTimer = null;
            this._endTimer = null;
        },
        methods:{
            loadOdds:function(){
                var vm = this;
                axios.get('/odds',{
                    params:{
                        group:this.$route.params.groupId
                    }
                }).then(function (response) {
                    var json= response.data;

                    vm.$emit('setOpeningOdds', json.data)
                })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            loadOpening:function () {
                var vm = this;
                axios.get('/opening',{
                    params:{
                        game:vm.game.id
                    }
                }).then(function (response) {
                    var json= response.data;

                    vm.$emit('setIssue',json.data.issue);
                    vm.end_time = json.data.end;
                    vm.half_reload = vm.interval_time > 60  ? Math.floor(vm.interval_time / 2) : 30;
                    vm.opening_time = json.data.open;
                    vm.interval_time = json.data.interval;
                    if(vm.end_time>1){
                        vm.$emit('setOddsLock', false);
                    }
                    vm.endTimer();
                    vm.openingTimer();
                    vm.intervalTimer();
                    vm.loadOdds()
                })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            endTimer(){
                var vm = this;
                vm._endTimer = setInterval(function () {

                    if(vm.end_time<=1){
                        clearInterval(vm._endTimer);
                        vm.$emit('setOddsLock', true);
                    }
                    vm.end_time--;
                },1000)
            },
            openingTimer(){
                var vm = this;
                vm._openingTimer = setInterval(function () {
                    if(vm.opening_time<=1){
                        clearInterval(vm._openingTimer);
                        vm.interval_time = 5;
                        vm.$emit('setOddsLock', true);
                        vm.$emit('reloadLastSwitch', true);
                    }
                    vm.opening_time--;
                },1000);
            },
            intervalTimer(){
                var vm = this;
                vm._intervalTimer = setInterval(function () {
                    if(vm.interval_time==vm.half_reload){
                        vm.$emit('reloadLastSwitch', true);
                    }
                    if(vm.interval_time<=1){
                        clearInterval(vm._intervalTimer);

                        axios.get('/opening',{
                            params:{
                                game:vm.game.id
                            }
                        }).then(function (response) {
                            var json = response.data;

                            vm.$emit('setIssue',json.data.issue);
                            if(vm.oddsLock){

                                if(json.data.end>1){
                                    vm.end_time = json.data.end;
                                    vm.$emit('setOddsLock', false);
                                    clearInterval(vm._endTimer);
                                    vm.endTimer();
                                }
                                if(json.data.open>5){
                                    vm.opening_time = json.data.open;
                                    clearInterval(vm._openingTimer);
                                    vm.openingTimer();
                                }
                            }
                            vm.loadOdds();
                            vm.interval_time = json.data.interval;
                            vm.intervalTimer();
                        }).catch(function (error) {
                            console.log(error)
                        })
                    }
                    vm.interval_time--;
                },1000);
            }
        },
        filters:{
            formatMinuteTime:function (time) {
                if(time<0){
                    time = 0;
                }
                var MinutesRound = Math.floor(time / 60);
                var SecondsRound = Math.round(time - (60 * MinutesRound));
                var Minutes = MinutesRound.toString().length <= 1 ? "0" + MinutesRound : MinutesRound;
                var Seconds = SecondsRound.toString().length <= 1 ? "0" + SecondsRound : SecondsRound;
                return Minutes + ":" + Seconds;
            }

        }
    }
</script>

<style scoped>
    .table{
        width: 700px;
        margin-left: 12px;
    }
    .openingIssue{
        color:#009900; font-weight:bold; font-size:14px;
    }
</style>
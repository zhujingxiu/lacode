<div id="appOdds">
<table class="th" border="0" cellpadding="0" cellspacing="0" style="margin-top:8px;top:10px;">
    <tbody>
    <tr>
        <td width="142" height="28" class="bolds">{{$group->game->title}}　</td>

        <td style="color:red;font-weight: bold;width: 80px">今天輸贏：</td>
        <td><span id="sy" class="shuyingjieguo2">0.0</span></td>
        <td align="right">&nbsp;</td>
        <td class="bolds" width="146">
            <span id="number" v-text="lastIssue"></span>期賽果
        </td>
        <td width="24" v-for="(item, index) in lastLottery" v-bind:class="noStyle+item"></td>
    </tr>
    </tbody>
</table>
<table class="th" border="0" cellpadding="0" cellspacing="0" style="margin-top:0px;">
    <tbody>
    <tr>
        <td height="30" width="90px">
            <span id="o" style=" color:#009900; font-weight:bold; font-size:14px;position:relative; top:1px" v-text="issue"></span>期
        </td>
        <td width="160"><span style="color:#0033FF; font-weight:bold" id="tys">{{$group->title}}</span></td>

        <td>距離封盤：<span style="font-size:104%" id="endTime" v-html="$options.filters.formatMinuteTime(end_second)"></span></td>
        <td colspan="6">
            距離開獎：<span style="color:red;font-size:104%" id="endTimes" v-html="$options.filters.formatMinuteTime(open_second)"></span>
        </td>
        <td colspan="2" align="right">
            <span id="endTimea" v-text="interval_second"></span>秒
        </td>
    </tr>
    </tbody>
</table>

</div>

<script>
    new Vue({
        el: '#appOdds',
        data: {
            lastIssue: '',
            lastLottery:[],
            noStyle:'',
            issue:'',
            end_second:0,
            open_second:0,
            interval_second:0,
            odds_lock: false,
            _refresh_timer: null,
            _opening_timer: null,
            _end_timer: null,
        },
        filters:{
            formatMinuteTime:function (time) {
                var MinutesRound = Math.floor(time / 60);
                var SecondsRound = Math.round(time - (60 * MinutesRound));
                var Minutes = MinutesRound.toString().length <= 1 ? "0" + MinutesRound : MinutesRound;
                var Seconds = SecondsRound.toString().length <= 1 ? "0" + SecondsRound : SecondsRound;
                return Minutes + ":" + Seconds;
            }

        },
        destroyed() {
            clearInterval(this._refresh_timer);
            clearInterval(this._opening_timer);
            clearInterval(this._end_timer);
        },
        created:function () {
            this.loadLastIssue();
            this.loadOpening();
        },
        methods:{
            loadLastIssue:function () {
                var vm = this;
                axios.get('{{route('member.last')}}',{
                    params:{
                        game:'{{$group->game->id}}'
                    }
                }).then(function (response) {
                        var json= response.data;
                        vm.lastIssue = json.data.lottery.issue;
                        vm.lastLottery = json.data.lottery.numbers;
                        vm.noStyle = json.data.no_style;

                    })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            loadOpening:function () {
                var vm = this;
                axios.get('{{route('member.issue')}}',{
                    params:{
                        game:'{{$group->game->id}}'
                    }
                }).then(function (response) {
                        var json= response.data;
                        vm.issue = json.data.issue;
                        vm.refreshTimer(json.data.refresh_second);
                        vm.openingTimer(json.data.open_time);
                        vm.endTimer(json.data.end_time);

                    })
                    .catch(function (error) {
                        console.log(error)
                    })
            },
            loadOdds:function () {

            },
            refreshTimer:function (interval_time) {
                this.interval_second = interval_time;
                var vm = this;
                this._refresh_timer = setInterval(function () {
                    if(vm.interval_second==30){
                        vm.loadLastIssue();
                    }
                    if(vm.interval_second<=1) {
                        console.log('before refreshTimer'+vm._refresh_timer);
                        clearInterval(vm._refresh_timer);
                        console.log('after refreshTimer'+vm._refresh_timer);
                        axios.get('{{route('member.issue')}}',{
                            params:{
                                game:'{{$group->game->id}}'
                            }
                        }).then(function (response) {
                            var json= response.data;
                            // if (vm.odds_lock == true) {
                            //     vm.endtimes(data.endTime);
                            //     vm.opentimes(data.openTime);
                            //     // loadinput(data.endTime);
                            //     vm.loadLastIssue();
                            //     vm.odds_lock = false;
                            // }
                            vm.issue = json.data.issue;
                            vm.refreshTimer(json.data.refresh_second);
                            vm.openingTimer(json.data.open_time);
                            vm.endTimer(json.data.end_time);
                            vm.loadLastIssue();
                        })
                    }
                    vm.interval_second--;

                },1000);


            },
            openingTimer:function (seconds) {
                this.open_second = seconds;
                var vm = this;
                this._opening_timer = setInterval(function () {
                    if (vm.open_second <= 1) {
                        console.log('before openingTimer'+vm._opening_timer);
                        clearInterval(vm._opening_timer);
                        console.log('after openingTimer'+vm._opening_timer);
                    }

                    vm.open_second--;
                },1000);
            },
            endTimer:function (seconds) {
                this.end_second = seconds;
                var vm = this;
                this._end_timer = setInterval(function () {
                    if (vm.end_second <= 1) {
                        console.log('before endTimer'+vm._end_timer);
                        clearInterval(vm._end_timer);
                        console.log('after endTimer'+vm._end_timer);
                        vm.odds_lock = true;
                    }

                    vm.end_second--;
                },1000);
            },

        }

    });

</script>
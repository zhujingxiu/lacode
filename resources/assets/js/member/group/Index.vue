<template>
    <div id="group-odds">
        <template v-if="issueEnable">
            <div class="col-left">
                <Last :group="group"
                      :game="game"
                      :reloadLast="reloadLast"
                      :lastIssue="lastIssue"
                      @setLastIssue="setLastIssue"
                      @setOddsLock="setOddsLock"
                      @reloadLastSwitch="reloadLastSwitch"></Last>
                <Opening :game="game"
                         :issue="issue"
                         :oddsLock="oddsLock"
                         @setIssue="setIssue"
                         @setOddsLock="setOddsLock"
                         @setOpeningOdds="setOpeningOdds"
                         @reloadLastSwitch="reloadLastSwitch"></Opening>
                <form method="post" ref="formOrder">

                    <component :is="group.tpl"
                               :issue="issue"
                               :oddsLock="oddsLock"
                               :openingOdds="openingOdds"
                               :quickMoney="quickMoney"
                               :quickChecked="quickChecked"></component>
                    <QuickBuy :oddsLock="oddsLock"
                              :quickMoney="quickMoney"
                              @addQuickMoney="addQuickMoney"
                              @setQuickMoney="setQuickMoney"
                              :quickChecked="quickChecked"
                              @setQuickChecked="setQuickChecked"></QuickBuy>
                </form>
            </div>
            <div class="col-right">
                <Latest :game="game"
                        :reloadLatest="reloadLatest"
                        @reloadLatestSwitch="reloadLatestSwitch"></Latest>
                <Counts :game="game"
                        :reloadCounts="reloadCounts"
                        @reloadCountsSwitch="reloadCountsSwitch"></Counts>
            </div>
        </template>
        <template v-else>


            <embed src="img/member/T0.swf" height="400" width="700"/>
        </template>
    </div>
</template>

<script>
    import Last from './Last'
    import Opening from './Opening'
    import QuickBuy from './QuickBuy'
    import HorizontalOdds from './HorizontalOdds'
    import VerticalOdds from './VerticalOdds'
    import Latest from './Latest'
    import Counts from './Counts'
    export default {
        name: "Group",
        data(){
            return {
                game: {},
                group: {},
                issue: '',
                issueEnable: true,
                lastIssue: '',
                oddsLock:true,
                reloadLast:true,
                reloadLatest:true,
                reloadCounts:true,
                openingOdds:{},
                quickChecked: true,
                quickMoney:''
            }
        },
        created:function () {
            this.loadGroup();
            //this.loadOdds();
        },
        watch:{
            lastIssue(){
                if(this.issue == this.lastIssue){
                    this.setOddsLock(true);
                }
            }
        },
        methods:{
            loadGroup:function(){
                var vm = this;
                axios.get('/group',{
                    params:{
                        group:this.$route.params.groupId
                    }
                }).then(function (response) {
                    var json= response.data;
                    if(json.error_code>0){
                        vm.issueEnable = false;
                        return false;
                    }
                    vm.issueEnable = true;
                    vm.game = json.data.game;
                    vm.group = json.data.group;
                })
                    .catch(function (error) {
                        console.log(error);
                    })
            },
            optionSelected:function (className) {
                var options = document.getElementsByClassName(className);
                for(let i=0;i<options.length;i++){
                    this.addClass(options[i],'_option_selected')
                }
            },
            clearSelected(){
                var options = document.getElementsByClassName('_option_selected');
                var elements = [];
                for(let i in options){
                    elements[i] = options[i]
                }
                for(let i in elements){
                    this.delClass(elements[i],'_option_selected')
                }
            },
            setOddsLock(value){
                this.oddsLock = value
            },
            setQuickChecked(value){
                this.quickChecked = value
            },
            setOpeningOdds(data){
                this.openingOdds = data;
            },
            reloadLastSwitch(value){
                this.reloadLast = value;
                this.reloadLatest = value;
                this.reloadCounts = value;
            },
            reloadLatestSwitch(value){
                this.reloadLatest = value;
            },
            reloadCountsSwitch(value){
                this.reloadCounts = value;
            },
            setIssue(issue){
                this.issue = issue;
            },
            setLastIssue(issue){
                this.lastIssue = issue;
            },

            setQuickMoney(money){
                if(!this.isNumeric(money)){
                    this.quickMoney = 0;
                }
                this.quickMoney = money
            },
            addQuickMoney(money){
                if(!this.isNumeric(this.quickMoney) ){
                    this.quickMoney = 0
                }
                this.quickMoney = Math.max(this.quickMoney + money,0);
            },
            hasClass(obj, className) {
                return obj.className && obj.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'))
            },
            addClass(obj, className){
                if (!this.hasClass(obj, className)) {
                    obj.className += " " + className;
                }
            },
            delClass(obj, className) {
                if (this.hasClass(obj, className)) {
                    var reg = new RegExp('(\\s|^)' + className + '(\\s|$)');
                    obj.className = obj.className.replace(reg, ' ');
                }
            },
            nextnNode(node){
                var next = node.nextSibling;
                if(next !== null && next.nodeType === 3){ //防止内联元素在ie下出现的空白节点和火狐下的空白节点
                    return next.nextSibling;
                }
                return next;
            },
            mathAdd (a, b) {
                var c, d, e;
                try {
                    c = a.toString().split(".")[1].length;
                } catch (f) {
                    c = 0;
                }
                try {
                    d = b.toString().split(".")[1].length;
                } catch (f) {
                    d = 0;
                }
                return e = Math.pow(10, Math.max(c, d)), (this.mathMul(a, e) + this.mathMul(b, e)) / e;
            },
            mathSub (a, b) {
                var c, d, e;
                try {
                    c = a.toString().split(".")[1].length;
                } catch (f) {
                    c = 0;
                }
                try {
                    d = b.toString().split(".")[1].length;
                } catch (f) {
                    d = 0;
                }
                return e = Math.pow(10, Math.max(c, d)), (this.mathMul(a, e) - this.mathMul(b, e)) / e;
            },
            mathMul(a, b) {
                var c = 0,
                    d = a.toString(),
                    e = b.toString();
                try {
                    c += d.split(".")[1].length;
                } catch (f) {
                }
                try {
                    c += e.split(".")[1].length;
                } catch (f) {
                }
                return Number(d.replace(".", "")) * Number(e.replace(".", "")) / Math.pow(10, c);
            },
            mathDiv(a, b) {
                var c, d, e = 0,
                    f = 0;
                try {
                    e = a.toString().split(".")[1].length;
                } catch (g) {
                }
                try {
                    f = b.toString().split(".")[1].length;
                } catch (g) {
                }
                return c = Number(a.toString().replace(".", "")), d = Number(b.toString().replace(".", "")), this.mathMul(c / d, Math.pow(10, f - e));
            },
            isNumeric:(obj)=> typeof obj === 'number' && isFinite(obj),
        },
        components:{
            Last,
            Opening,
            HorizontalOdds,
            VerticalOdds,
            QuickBuy,
            Counts,
            Latest,
        }
    }
</script>

<style scoped>
    #group-odds{
        clear:both;
    }
    .col-left, .col-right{
        float: left;
    }
    .col-right{
        margin: 15px 10px;
    }

</style>
<template>
        <table bgcolor="#E9BA84" cellspacing="1" width="170">
            <tbody>
            <tr class="t_list_caption">
                <th :colspan="11"><font color="#4A1A04">最近十二期開獎走勢</font></th>
            </tr>
            <tr bgcolor="#fff" height="20" v-for="(lottery, issue, index) in lotteries" :key="index">
                <td class="simpleIssue">{{issue|formatIssue}}</td>
                <td class="simpleNumbers" v-for="no_value in lottery">
                    {{no_value}}
                </td>
            </tr>
            </tbody>
        </table>
</template>

<script>
    export default {
        name: "Latest",
        props: ['game','reloadLatest'],
        data(){
            return {
                lotteries: []
            }
        },
        watch:{
            game: function(){
                this.loadLatest();
            },
            reloadLatest(){
                if(this.reloadLatest){
                    this.loadLatest();
                }
            }
        },
        methods:{
            loadLatest(){
                var vm = this;
                axios.get('/latest',{
                    params:{
                        game:vm.game.id
                    }
                }).then(function (response) {
                    var json= response.data;
                    vm.lotteries = json.data;
                    vm.$emit('reloadLatestSwitch',false);
                })
                .catch(function (error) {
                    console.log(error)
                })
            }
        },
        filters:{
            formatIssue(issue){
                return issue.slice(-3)
            }
        }
    }
</script>

<style scoped>
    .simpleIssue{
        background:#ffffff; color:red; text-align:center;
    }
    .simpleNumbers{
        background:#fff4eb; color:#511e02;text-align:center;
    }
</style>
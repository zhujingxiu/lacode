<template>
    <table bgcolor="#E9BA84" cellspacing="1" width="170">
        <tbody>
        <tr class="t_list_caption">
            <th colspan="2"><font color="#4A1A04">兩面長龍排行</font></th>
        </tr>
        <tr bgcolor="#fff" height="20" v-for="(item,  index) in counts" :key="index">

            <td class="simpleNumbers" v-html="item.title"> </td>
            <td class="simpleIssue">{{item.count}}期</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "Counts",
        props: ['game','reloadCounts'],
        data(){
            return {
                counts: []
            }
        },
        watch:{
            game: function(){
                this.loadCounts();
            },
            reloadCounts(){
                if(this.reloadCounts){
                    this.loadCounts();
                }
            }
        },
        methods:{
            loadCounts(){
                var vm = this;
                axios.get('/counts',{
                    params:{
                        game:vm.game.id
                    }
                }).then(function (response) {
                    var json= response.data;
                    vm.counts = json.data;
                    vm.$emit('reloadCountsSwitch',false);
                })
                    .catch(function (error) {
                        console.log(error)
                    })
            }
        },
    }
</script>

<style scoped>
    .simpleIssue{
        background:#ffffff; width:35px; color:red; text-align:center;
    }
    .simpleNumbers{
        background:#fff4eb; color:#511e02;text-align:center;
    }
</style>
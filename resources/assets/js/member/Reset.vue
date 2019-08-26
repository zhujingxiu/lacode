<template>
    <div style="margin-left:10px;margin-top:20px;">
        <form action="" method="post">
        <table border="0" cellpadding="0" cellspacing="1" class="t_list t_result" >
            <tbody><tr>
                <td class="t_list_caption" colspan="2">變更密碼</td>
            </tr>
            <tr style="height:28px">
                <td style="text-align:right" class="t_td_caption_1" width="28%">原密碼&nbsp;</td>
                <td class="t_td_text" width="530">
                    <input class="inp1" type="password" name="VIP_PWD_old" style="margin-left:3px;width:140px;">
                </td>
            </tr>
            <tr style="height:28px">
                <td style="text-align:right" class="t_td_caption_1" width="28%">新密碼&nbsp;</td>
                <td class="t_td_text" width="530">
                    <input class="inp1" type="password" name="VIP_PWD" style="margin-left:3px;width:140px;">
                </td>
            </tr>
            <tr style="height:28px">
                <td style="text-align:right" class="t_td_caption_1" width="28%">確認密碼&nbsp;</td>
                <td class="t_td_text" width="530">
                    <input class="inp1" type="password" style="margin-left:3px;width:140px;" name="VIP_PWD1">
                </td>
            </tr>
            </tbody></table>
        <br>
        <table border="0" cellpadding="0" cellspacing="1" width="700" >
            <tbody>
            <tr>
                <td colspan="2" align="center">
                    <input style="color:#004400" type="submit" value="確定脩改" class="inputa_2">
                </td>
            </tr>
            </tbody>
        </table>
        </form>
    </div>

</template>

<script>
    export default {
        name: "Reset"
    }
</script>

<style scoped>

</style>
<input style="height:22px;padding: 0px 5px 2px 5px;" type="button" name="ut0" id="ut0" onclick="locationFile(0);" value="启用">
<div id="oddsPops0" style="position:absolute;width:190px;display:none">
    <table border="0" cellspacing="0" class="t_odds" width="100%">
        <tbody>
        <tr class="tr_top">
            <th align="right">修改賬戶狀態</th>
            <th width="27%" align="right">
                <img src="/img/merchant/del.gif" onclick="diplaydiv(0);" title="关闭">
            </th>
        </tr>
        <tr class="text" style="height:35px;text-align:center">
            <td id="showPas0" colspan="2">
                <input name="lock0" type="radio" value="1" checked="checked" onclick="changeAjax(this.value,'{{$merchant->name}}',1,0);">
                启用&nbsp;
                <input name="lock0" type="radio" value="2" onclick="changeAjax(this.value,'{{$merchant->name}}',1,0);">
                凍結&nbsp;
                <input name="lock0" type="radio" value="3" onclick="changeAjax(this.value,'{{$merchant->name}}',1,0);">
                停用&nbsp;
            </td>
        </tr>
        </tbody>
    </table>
</div>
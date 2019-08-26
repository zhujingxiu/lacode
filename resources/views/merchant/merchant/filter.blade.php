<form class="filterForm" action="{{$action}}">
    <table border="0" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td width="18"><img src="/img/merchant/fh.gif"></td>
            <td width="35" align="left">
                <a href="javascript:history.go(-1);" class="font_r F_bold">
                    <font color="#FF0000" style="font-weight:bold">返囬</font>
                </a>
            </td>
            <td width="150" align="left" >
                <select class="filterItem" name="status">
                    <option value="*">选择状态</option>
                    <option value="1" {{request('status')==1 ? 'selected':''}}>啟用</option>
                    <option value="-1" {{request('status')==-1 ? 'selected':''}}>凍結</option>
                    <option value="0" {{\Request::has('status') && request('status')==0 ? 'selected':''}}>停用</option>
                </select>
            </td>
            <td width="150" align="left">
                <input type="text" placeholder="賬戶" maxlength="30" name="name" class="filterItem textb" value="{{request('name')}}">
            </td>
            <td width="150" align="left">
                <input type="text" placeholder="名稱" maxlength="30" name="nick_name" class="filterItem textb" value="{{request('nick_name')}}">
            </td>
            <td>
                <input id="filter" class="filterSubmit" type="button" value="搜索">
            </td>
        </tr>
        </tbody>
    </table>
</form>
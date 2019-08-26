@extends('merchant.base.main')
@section('content')
    <div id="page-content">
        <form action="" method="post" onsubmit="return isForm()">
            <table width="100%" height="99.3%" border="0" cellspacing="0" class="a">
                <tbody><tr>
                    <td width="5" height="100%" bgcolor="#4F4F4F"></td>
                    <td class="c">
                        <table border="0" cellspacing="0" class="main">
                            <tbody><tr>
                                <td width="12"><img src="{{asset('img/merchant/tab_03.gif')}}" alt=""></td>
                                <td background="{{asset('img/merchant/tab_05.gif')}}"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tbody><tr>
                                            <td width="17"><img src="{{asset('img/merchant/tb.gif')}}" width="16" height="16"></td>
                                            <td width="99%"><font style="font-weight:bold" color="#344B50">&nbsp;系統管理</font></td>
                                        </tr>
                                        </tbody></table></td>
                                <td width="16"><img src="{{asset('img/merchant/tab_07.gif')}}" alt=""></td>
                            </tr>
                            <tr>

                                <td class="t"></td>
                                <td class="c">

                                    <!-- strat -->
                                    <table border="0" cellspacing="0" class="conter tableStriped">
                                        <tbody>
                                        <tr class="tr_top">
                                            <th colspan="2">基本設置</th>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">網站開啟:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="web_lock" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="web_lock" value="0">
                                            </td>
                                        </tr>
                                        <tr style="height:36px">
                                            <td class="bj">網站关闭提示:</td>
                                            <td class="left_p6">
                                                <textarea style="height:20px;color:red" name="web_text">娱乐</textarea>
                                                &nbsp;&nbsp;
                                                現在关闭提示：[娱乐]
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">自動補貨限制:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="automatic_bu_huo_lock" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="automatic_bu_huo_lock" value="0">
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">占成自由調整:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="g_gxdh" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="g_gxdh" value="0">
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">日誌保存:</td>
                                            <td class="left_p6">
                                                <input class="textc" type="text" name="login_log_lock" value="15">
                                                &nbsp;&nbsp;
                                                <span class="odds">(系統將會自動刪除超出天數的日誌;需要修改請聯系技術員.)</span>
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">過期時間:</td>
                                            <td class="left_p6">
                                                <input class="textc" type="text" name="out_time" value="30">
                                                &nbsp;&nbsp;
                                                <span class="odds">分鐘(用戶連續幾分鍾不動系統自動Ｔ出。)</span>
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">報表查詢:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="cry_select_lock" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="cry_select_lock" value="0">
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">即時注單:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="nowrecord_lock" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="nowrecord_lock" value="0">
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">動態賠率:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="odds_execution_lock" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="odds_execution_lock" value="0">
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">單號最高限額:</td>
                                            <td class="left_p6">
                                                <input class="textc" type="text" name="max_money" value="500000">
                                                &nbsp;&nbsp;
                                                <span class="odds">(僅統計未結算注單)</span>
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">單注最低金額:</td>
                                            <td class="left_p6">
                                                <input class="textc" type="text" name="mix_money" value="5">
                                                &nbsp;&nbsp;
                                                <span class="odds">元(包括自動補貨、手工補貨;至少設置1元，建議設置2元。)</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table border="0" cellspacing="0" class="conter tableStriped">
                                        <tbody>
                                        <tr class="tr_top">
                                            <th colspan="2">特殊設置</th>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">自動結算:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="automatic_money_lock" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="automatic_money_lock" value="0">
                                                &nbsp;&nbsp;
                                                <span class="red">（此項關閉后，不会结算注单！）</span>
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">自動開盤:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="automatic_open_number_lock" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="automatic_open_number_lock" value="0">
                                                &nbsp;&nbsp;
                                                <span class="red">（此項關閉后，自動結算、動態賠率、自動加載期數、封盤時間、功能將失效）</span>
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">自動開獎:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="automatic_open_result_lock" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="automatic_open_result_lock" value="0">
                                                &nbsp;&nbsp;
                                                <span class="red">（此項關閉后，只自動開盤，不会采集开奖数据）</span>
                                            </td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj">重庆自動開獎:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="g_cp_ope" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="g_cp_ope" value="0">
                                                &nbsp;&nbsp;
                                                <span class="red">（此項關閉后，只自動開盤，重庆不会采集开奖数据）</span>
                                            </td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj">極速時時彩自動開獎:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="g_jxssc_op" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="g_jxssc_op" value="0">
                                                &nbsp;&nbsp;
                                                <span class="red">（此項關閉后，只自動開盤，極速時時彩不会采集开奖数据）</span>
                                            </td>
                                        </tr>

                                        <tr style="height:38px;">
                                            <td class="bj">北京PK10自動開獎:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="g_pk_ope" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="g_pk_ope" value="0">
                                                &nbsp;&nbsp;
                                                <span class="red">（此項關閉后，只自動開盤，北京PK10不会采集开奖数据）</span>
                                            </td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj">極速賽車自動開獎:</td>
                                            <td class="left_p6"> 開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="g_pkjssc_ope" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="g_pkjssc_ope" value="0">
                                                &nbsp;&nbsp;
                                                <span class="red">（此項關閉后，只自動開盤，極速賽車不会采集开奖数据）</span>
                                            </td>
                                        </tr>

                                        <tr style="height:38px;">
                                            <td class="bj">幸运飞艇自動開獎:</td>
                                            <td class="left_p6"> 開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="g_xyft_op" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="g_xyft_op" value="0">
                                                &nbsp;&nbsp;
                                                <span class="red">（此項關閉后，只自動開盤，不采集）</span>
                                            </td>
                                        </tr>

                                        <tr style="height:38px">
                                            <td class="bj">每天开盤時間:</td>
                                            <td class="left_p6">
                                                <span class="odds">重慶時時彩:</span>&nbsp;
                                                <input class="textc" type="text" name="open_time_cq" id="open_time_cq" style="width:90px" value="00:30:00">
                                                &nbsp;&nbsp;   <span class="odds">北京赛车PK10:</span>&nbsp;
                                                <input class="textc" type="text" name="open_time_pk" id="open_time_pk" style="width:90px" value="09:30:00">
                                                &nbsp;&nbsp;   <span class="odds">幸运飞艇:</span>
                                                <input class="textc" type="text" name="open_time_xyft" id="open_time_xyft" style="width:90px;" value="13:09:00">  <span class="odds">極速賽車:</span>&nbsp;
                                                <input class="textc" type="text" name="open_time_pkjssc" id="open_time_pkjssc" style="width:90px" value="08:00:00">
                                                &nbsp;&nbsp;  <span class="odds">極速時時彩:</span>&nbsp;
                                                <input class="textc" type="text" name="open_time_jxssc" id="open_time_jxssc" style="width:90px" value="08:00:00">
                                                &nbsp;&nbsp; 			 <br>
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">金額還原:</td>
                                            <td class="left_p6">
                                                開啟&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="radio" name="restore_money_lock" value="1">
                                                &nbsp;&nbsp;
                                                關閉&nbsp;
                                                <input style="position:relative;top:2px" type="radio" name="restore_money_lock" value="0">
                                                <input type="button" onclick="hybyh();" value="手動還原">
                                            </td>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">极速盈利百分比:</td>
                                            <td class="left_p6">
                                                <input class="textc" type="text" name="g_zgpl" maxlength="2" value="50">%
                                                &nbsp;&nbsp;
                                            </td>
                                        </tr>

                                        <tr style="height:38px">
                                            <td class="bj">額度校驗:</td>
                                            <td class="left_p6">
                                                <input type="button" onclick="hybyhxy();" value="額度校驗">
                                                &nbsp;&nbsp;
                                                <span class="odds">(如信用余額對不上, 請手動校驗即可.)</span>&nbsp;
                                            </td>
                                        </tr>
                                        <tr style="height:38px;  ">
                                            <td class="bj">會員設置:</td>
                                            <td class="left_p6">&nbsp;
                                                <a href="WainAll.php"><font color="red">【<b>會員註單必中設置</b>】</font></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table border="0" cellspacing="0" class="conter tableStriped">
                                        <tbody>
                                        <tr class="tr_top">
                                            <th colspan="2">彩種管理</th>
                                        </tr>
                                        <tr style="height:38px">
                                            <td class="bj">彩種開啟:</td>
                                            <td class="left_p6">
                                                重慶時時彩&nbsp;
                                                <input style="position:relative;top:2px" type="checkbox" name="cq_game_lock" checked="checked" value="1">
                                                &nbsp;&nbsp;

                                                極速時時彩&nbsp;
                                                <input style="position:relative;top:2px" type="checkbox" name="jxssc_game_lock" checked="checked" value="1">
                                                &nbsp;&nbsp;
                                                北京赛车PK10&nbsp;
                                                <input style="position:relative;top:2px" type="checkbox" name="pk_game_lock" checked="checked" value="1">
                                                &nbsp;&nbsp;
                                                極速賽車&nbsp;
                                                <input style="position:relative;top:2px" type="checkbox" name="pkjssc_game_lock" checked="checked" value="1">
                                                &nbsp;&nbsp;
                                                <span>幸运飞艇&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="xyft_game_lock" value="1"></span>
                                                &nbsp;
                                            </td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj"><b>重慶時時彩:</b></td>
                                            <td class="left_p6"> 第一球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_cq_1" value="1">
                                                &nbsp;&nbsp;
                                                第二球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_cq_2" value="1">
                                                &nbsp;&nbsp;
                                                第三球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_cq_3" value="1">
                                                &nbsp;&nbsp;
                                                第四球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_cq_4" value="1">
                                                &nbsp;&nbsp;
                                                第五球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_cq_5" value="1">
                                                &nbsp;&nbsp;
                                                總分龍虎&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_cq_6" value="1">
                                                &nbsp;&nbsp;
                                                前三、中三、后三&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_cq_7" value="1">
                                                &nbsp;&nbsp; </td>
                                        </tr>
                                        <tr style="height:38px; display:none">
                                            <td class="bj">B盤:</td>
                                            <td class="left_p6"> 1-5號碼:&nbsp;
                                                <input type="text" class="textc" name="odds_ratio_cq_b1" value="0.02">
                                                &nbsp;
                                                兩面:&nbsp;
                                                <input type="text" class="textc" name="odds_ratio_cq_b2" value="0.03">
                                                &nbsp;&nbsp;
                                                前三、中三、后三:&nbsp;
                                                <input type="text" class="textc" name="odds_ratio_cq_b3" value="0.04"></td>
                                        </tr>
                                        <tr style="height:38px; display:none">
                                            <td class="bj">C盤:</td>
                                            <td class="left_p6"> 1-5號碼:&nbsp;
                                                <input type="text" class="textc" name="odds_ratio_cq_c1" value="0.03">
                                                &nbsp;
                                                兩面:&nbsp;
                                                <input type="text" class="textc" name="odds_ratio_cq_c2" value="0.04">
                                                &nbsp;&nbsp;
                                                前三、中三、后三:&nbsp;
                                                <input type="text" class="textc" name="odds_ratio_cq_c3" value="0.05"></td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj">動態賠率:</td>
                                            <td class="left_p6"> 連續值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="up_odds_mix_cq" value="999">
                                                &nbsp;&nbsp;
                                                1-5球總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_num_cq" value="999">
                                                &nbsp;&nbsp;
                                                雙面總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_str_cq" value="999">
                                                &nbsp;&nbsp; <span class="odds">(超出連續值以設置的總值累加，執行賠率變動。)</span></td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj"><b>極速時時彩:</b></td>
                                            <td class="left_p6"> 第一球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_jxssc_1" value="1">
                                                &nbsp;&nbsp;
                                                第二球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_jxssc_2" value="1">
                                                &nbsp;&nbsp;
                                                第三球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_jxssc_3" value="1">
                                                &nbsp;&nbsp;
                                                第四球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_jxssc_4" value="1">
                                                &nbsp;&nbsp;
                                                第五球&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_jxssc_5" value="1">
                                                &nbsp;&nbsp;
                                                總分龍虎&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_jxssc_6" value="1">
                                                &nbsp;&nbsp;
                                                前三、中三、后三&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_jxssc_7" value="1">
                                                &nbsp;&nbsp; </td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj">動態賠率:</td>
                                            <td class="left_p6"> 連續值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="up_odds_mix_jxssc" value="999">
                                                &nbsp;&nbsp;
                                                1-5球總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_num_jxssc" value="999">
                                                &nbsp;&nbsp;
                                                雙面總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_str_jxssc" value="999">
                                                &nbsp;&nbsp; <span class="odds">(超出連續值以設置的總值累加，執行賠率變動。)</span></td>
                                        </tr>

                                        <tr style="height:38px;">
                                            <td class="bj"><b>北京赛车PK10:</b></td>
                                            <td class="left_p6"> 冠、亞軍 組合&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_pk_1" value="1">
                                                &nbsp;&nbsp;
                                                三、四、伍、六名&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_pk_2" value="1">
                                                &nbsp;&nbsp;
                                                七、八、九、十名&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_pk_3" value="1">
                                                &nbsp;&nbsp; </td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj">動態賠率:</td>
                                            <td class="left_p6"> 連續值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="up_odds_mix_pk" value="999">
                                                &nbsp;&nbsp;
                                                1-10名總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_num_pk" value="999">
                                                &nbsp;&nbsp;
                                                雙面總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_str_pk" value="999">
                                                &nbsp;&nbsp; <span class="odds">(超出連續值以設置的總值累加，執行賠率變動。)</span></td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj"><b>極速賽車:</b></td>
                                            <td class="left_p6"> 冠、亞軍 組合&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_pkjssc_1" value="1">
                                                &nbsp;&nbsp;
                                                三、四、伍、六名&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_pkjssc_2" value="1">
                                                &nbsp;&nbsp;
                                                七、八、九、十名&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_pkjssc_3" value="1">
                                                &nbsp;&nbsp; </td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj">動態賠率:</td>
                                            <td class="left_p6"> 連續值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="up_odds_mix_pkjssc" value="999">
                                                &nbsp;&nbsp;
                                                1-10名總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_num_pkjssc" value="999">
                                                &nbsp;&nbsp;
                                                雙面總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_str_pkjssc" value="999">
                                                &nbsp;&nbsp; <span class="odds">(超出連續值以設置的總值累加，執行賠率變動。)</span></td>
                                        </tr>


                                        <tr style="height:38px;">
                                            <td class="bj"><b>幸运飞艇:</b></td>
                                            <td class="left_p6"> 冠、亞軍 組合&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_xyft_1" value="1">
                                                &nbsp;&nbsp;
                                                三、四、伍、六名&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_xyft_2" value="1">
                                                &nbsp;&nbsp;
                                                七、八、九、十名&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_xyft_3" value="1">
                                                &nbsp;&nbsp; </td>
                                        </tr>
                                        <tr style="height:38px;">
                                            <td class="bj">動態賠率:</td>
                                            <td class="left_p6"> 連續值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="up_odds_mix_xyft" value="999">
                                                &nbsp;&nbsp;
                                                1-10名總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_num_xyft" value="999">
                                                &nbsp;&nbsp;
                                                雙面總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_str_xyft" value="999">
                                                &nbsp;&nbsp; <span class="odds">(超出連續值以設置的總值累加，執行賠率變動。)</span></td>
                                        </tr>

                                        <tr style="height:38px;display:none;">
                                            <td class="bj"><b>極速飛艇:</b></td>
                                            <td class="left_p6"> 冠、亞軍 組合&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_xyftjsft_1" value="1">
                                                &nbsp;&nbsp;
                                                三、四、伍、六名&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_xyftjsft_2" value="1">
                                                &nbsp;&nbsp;
                                                七、八、九、十名&nbsp;
                                                <input checked="checked" style="position:relative;top:2px" type="checkbox" name="game_xyftjsft_3" value="1">
                                                &nbsp;&nbsp; </td>
                                        </tr>
                                        <tr style="height:38px;display:none;">
                                            <td class="bj">動態賠率:</td>
                                            <td class="left_p6">
                                                連續值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="up_odds_mix_xyftjsft" value="5">
                                                &nbsp;&nbsp;
                                                1-10名總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_num_xyftjsft" value="5">
                                                &nbsp;&nbsp;
                                                雙面總值&nbsp;
                                                <input class="textc" style="width:50px" type="text" name="odds_str_xyftjsft" value="5">
                                                &nbsp;&nbsp;
                                                <span class="odds">(超出連續值以設置的總值累加，執行賠率變動。)</span>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <!-- end -->
                                </td>
                                <td class="r"></td>
                            </tr>
                            <tr>
                                <td width="12"><img src="{{asset('img/merchant/tab_18.gif')}}" alt=""></td>
                                <td class="f" align="center"><input type="submit" class="inputs" value="確   定"></td>
                                <td width="16"><img src="{{asset('img/merchant/tab_20.gif')}}" alt=""></td>
                            </tr>
                            </tbody></table>
                    </td><td width="5" bgcolor="#4F4F4F"></td>

                </tr>
                <tr>
                    <td height="5" bgcolor="#4F4F4F"></td>
                    <td bgcolor="#4F4F4F"></td>
                    <td height="5" bgcolor="#4F4F4F"></td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
    @endsection
@section('script')
    <script>

    </script>
    @endsection
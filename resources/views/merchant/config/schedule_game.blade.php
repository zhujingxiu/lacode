<input type="hidden" name="game" value="{{$game->id}}">
<table border="0" cellspacing="0" class="conter tableStriped">
    <tbody>
    <tr class="tr_top">
        <th colspan="2">{{$game->title}}</th>
    </tr>
    <tr>
        <td height="36" class="bj">總期數</td>
        <td class="left_p6">{{$game->total}}</td>
    </tr>
    @foreach($game->schedules as $schedule)
    <tr>
        <td height="36" class="bj">开盘计划-{{$loop->iteration}}</td>
        <td class="left_p6">
            <table border="0" cellspacing="0" class="conter ">
                <tr>
                    <td>开始时间</td>
                    <td>每期间隔</td>
                    <td>封盘提前</td>
                    <td>总期数</td>
                </tr>
                <tr>
                    <td>{{$schedule->start_time}}</td>
                    <td>{{$schedule->interval}}秒</td>
                    <td>{{$schedule->ahead}}秒</td>
                    <td>{{$schedule->total}}</td>
                </tr>
            </table>
        </td>
    </tr>
    @endforeach
    <tr align="center" style="background:#F6FAFF; height:28px;">
        <td colspan="2">
            <input type="button" class="inputs load-issues" data-rel="{{$game->id}}" value="加載盤口">
        </td>
    </tr>
    </tbody>
</table>

<table border="0" cellspacing="0" class="conter tableStriped">
    <tbody>
    <tr class="tr_top">
        <td></td>
        <td>期數</td>
        <td>封盤時間</td>
        <td>開獎時間</td>
        <td width="150">狀態</td>
        <td width="120">基本操作</td>
    </tr>
    @foreach($game->schedule_issues as $schedule_issue)
    <tr align="center">
        <td>{{$loop->iteration}}</td>
        <td>{{$schedule_issue->issue}}</td>
        <td>{{$schedule_issue->end_time}}</td>
        <td style="color:red">{{$schedule_issue->open_time}}</td>
        <td>
            @if($schedule_issue->status==1)
            <span class="odds">正在開盤...</span>
                @else
                <span class="green">等待狀態</span>
                @endif
        </td>
        <td id="schedule-issue-{{$loop->iteration}}">
            <table border="0" cellspacing="0" cellpadding="0">
                <tbody>
                <tr>
                    <td class="nones" width="15"><img src="{{asset('img/merchant/edit.gif')}}"></td>
                    <td class="nones" width="30">
                    @if($schedule_issue->status==1)
                    <span class="red">已開</span>
                    @else
                        <a href="javascript:void(0)" class="delNumber('20190412037','2')">開盤</a>
                    @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
        @endforeach
</tbody>
</table>
<script>
    $('.load-issues').click(function () {
        
    })
</script>
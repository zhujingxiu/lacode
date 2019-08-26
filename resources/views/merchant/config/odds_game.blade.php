<input type="hidden" name="game" value="{{$game->id}}">
@foreach($game->groups as $group)

<table border="0" cellspacing="0" class="conter oddsbox">
    <tbody>
    @foreach($group->options as $option)
        @php
            $a_odds = isset($option->odds['a']) ? $option->odds['a'] : [];
            $d_odds = isset($option->odds['d']) ? $option->odds['d'] : $a_odds;
            $d_odds = $d_odds->chunk(10);
        @endphp
    <tr class="tr_top">
        <td colspan="10">{{$group->title}} -- {{$option->option->title}}</td>
    </tr>

        @foreach($d_odds as  $chunk)
            <tr>
            @foreach( $chunk as $odd)
                <td>{{$odd->bet->title}}</td>
            @endforeach
            </tr>
            <tr>
            @foreach( $chunk as $odd)
                <td><input type="text" class="inputFocus" isNumber="true" maxlength="6" name="odds[{{$odd->group_id}}][{{$odd->option_id}}][{{$odd->bet_id}}][d]" value="{{$odd->g_value}}"></td>
            @endforeach
            </tr>
        @endforeach
    @endforeach

    </tbody>
</table>
    @endforeach
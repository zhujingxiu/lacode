<?php

namespace App\Repositories;

use App\Libs\Game\Models\Game;
use App\Libs\Game\Models\GameBet;
use App\Libs\Game\Models\GameGroup;
use App\Libs\Game\Models\GameGroupOption;
use App\Libs\Game\Models\GameLottery;
use App\Libs\Game\Models\GameLotteryInfo;
use App\Libs\Game\Models\GameOdds;
use App\Libs\Game\Models\GameOption;
use App\Libs\Game\Models\GameScheduleIssue;
use Illuminate\Support\Facades\Redis;

class GameRepository
{
    public static function game($game_id)
    {
        $key = sprintf(config('site.game_key'),$game_id);
        $value = Redis::get($key);
        if(!$value){
            $game = Game::find($game_id);
            $value = json_encode($game->toArray());
            Redis::set($key, $value);
        }
        return json_decode($value,TRUE);
    }

    public static function gameGroups($game_id)
    {
        $key = sprintf(config('site.game_groups_key'),$game_id);
        $value = Redis::get($key);
        if(!$value){
            $groups = GameGroup::where(['game_id'=>$game_id,'status'=>1])->get()->keyBy('id');
            $value = json_encode($groups->toArray());
            Redis::set($key, $value);
        }
        return json_decode($value, TRUE);
    }

    public static function gameGroup($group_id)
    {
        $key = sprintf(config('site.game_group_key'),$group_id);
        $value = Redis::get($key);
        if(!$value){
            $group = GameGroup::find($group_id);
            $value = json_encode($group->toArray());
            Redis::set($key, $value);
        }
        return json_decode($value, TRUE);
    }


    public static function gameOptions($game_id)
    {
        $key = sprintf(config('site.game_options_key'),$game_id);
        $value = Redis::get($key);
        if(!$value){
            $options = GameOption::where(['game_id'=>$game_id,'status'=>1])->get()->keyBy('id');
            $value = json_encode($options->toArray());
            Redis::set($key, $value);
        }
        return json_decode($value, TRUE);
    }

    public static function gameOption($option_id)
    {
        $key = sprintf(config('site.game_option_key'),$option_id);
        $value = Redis::get($key);
        if(!$value){
            $option = GameOption::find($option_id);
            $value = json_encode($option->toArray());
            Redis::set($key, $value);
        }
        return json_decode($value, TRUE);
    }

    public static function gameBets($game_id)
    {
        $key = sprintf(config('site.game_bets_key'),$game_id);
        $value = Redis::get($key);
        if(!$value){
            $bets = GameBet::where(['game_id'=>$game_id,'status'=>1])->get()->keyBy('id');
            $value = json_encode($bets->toArray());
            Redis::set($key, $value);
        }
        return json_decode($value, TRUE);
    }

    public static function gameBet($bet_id)
    {
        $key = sprintf(config('site.game_bet_key'),$bet_id);
        $value = Redis::get($key);
        if(!$value){
            $bet = GameBet::find($bet_id);
            $value = json_encode($bet->toArray());
            Redis::set($key, $value);
        }
        return json_decode($value, TRUE);
    }

    public static function lastIssue($game_id)
    {
        $key = sprintf(config('site.last_issue_key'),$game_id);
        $value = Redis::get($key);
        if(!$value){
            $lottery = GameLottery::where(['game_id'=>$game_id])->orderBy('issue','desc')->first()->toArray();
            $numbers = [];
            $game = self::game($game_id);
            $no_fields = collect(range(1,$game['no_count']))->map(function ($index){
                return 'no_'.$index;
            })->toArray();
            foreach ($lottery as $key => $no_value){
                if(in_array($key,$no_fields)) {
                    $numbers[$key] = $no_value;
                }
            }
            $value = json_encode([
                'issue' => $lottery['issue'],
                'open_time'=> $lottery['open_time'],
                'numbers' => $numbers
            ]);
            Redis::set($key,$value);
        }
        return json_decode($value, TRUE);
    }

    public static function openingIssue($game_id)
    {
        $key = sprintf(config('site.opening_issue_key'),$game_id);
        $value = Redis::get($key);
        if(!$value) {
            $scheduleIssue = GameScheduleIssue::select(['issue','open_time','end_time','start_time'])->where(['game_id' => $game_id, 'status' => 1])->orderBy('issue', 'asc')->first();
            if(empty($scheduleIssue->issue)){
                return FALSE;
            }
            $value = json_encode([
                'issue' => $scheduleIssue->issue,
                'open_time'=> $scheduleIssue->open_time,
                'start_time'=> $scheduleIssue->start_time,
                'end_time'=> $scheduleIssue->end_time,
            ]);
            Redis::set($key,$value);
        }
        return json_decode($value, TRUE);
    }

    public static function groupOdds($group_id)
    {
        $key = sprintf(config('site.game_group_odds_key'),$group_id);
        $value = Redis::get($key);

        if(!$value) {
            $odds = [];
            $gameOdds = GameOdds::where(['group_id'=>$group_id])->get()->groupBy('roulette');
            foreach ($gameOdds as $_roulette => $item){

                $options = [];
                foreach ($item->groupBy('option_id') as $_option_id => $_bets){
                    $_option = self::gameOption($_option_id);
                    $bets = [];
                    foreach ($_bets as $_odds){
                        $_bet = self::gameBet($_odds['bet_id']);
                        $_bet['odds'] = $_odds['g_value'];
                        $bets[$_odds['bet_id']] = $_bet;
                    }
                    $_tmpOption = GameGroupOption::select(['show','style','remark','repeat','max','sort'])->where(['group_id'=>$group_id,'option_id'=>$_option_id])->first();
                    $_option['show'] = $_tmpOption->show;
                    $_option['remark'] = $_tmpOption->remark;
                    $_option['repeat'] = $_tmpOption->repeat;
                    $_option['max'] = $_tmpOption->max;
                    $_option['style'] = $_tmpOption->style;
                    if($_option['max'] && $_option['repeat'] == 'horizontal'){
                        $bets = collect($bets)->chunk($_option['max']);
                        $last_chunk = $bets->last();
                        if($last_chunk->count() < $_option['max']){
                            for ($i=0;$i<$_option['max']-$last_chunk->count();$i++){
                                //$last_chunk->push('');
                                $last_chunk[] = '';
                            }
                        }
                        $_option['bets'] = $bets;
                    }else{
                        $_option['bets'][] = $bets;
                    }
                    $options[$_option_id] = $_option;
                }

                $odds[$_roulette] = $options;
            }
            $value = json_encode($odds);
            Redis::set($key, $value);
        }
        return json_decode($value, TRUE);
    }

    public static function latestLotteries($game_id,$limit=12)
    {
        $key = sprintf(config('site.latest_issue_lotteries_key'),$game_id);
        $value = Redis::lrange($key, 0, $limit);
        if(!$value){
            $lotteries = GameLottery::where('game_id',$game_id)->orderBy('issue','desc')->limit($limit)->get()->toArray();
            foreach ($lotteries as $lottery){
                $numbers = [];
                $game = self::game($game_id);
                $no_fields = collect(range(1,$game['no_count']))->map(function ($index){
                    return 'no_'.$index;
                })->toArray();
                foreach ($lottery as $key => $no_value){
                    if(in_array($key,$no_fields)) {
                        $numbers[$key] = $no_value;
                    }
                }
                $tmp = json_encode([
                    'issue' => $lottery['issue'],
                    'numbers' => $numbers
                ]);
                $value[] = $tmp;
                Redis::rpush($key, $tmp);
            }
        }

        return $value;
    }

    public static function lotteryCounts($game_id,$countsLimit=20, $issueLimit=12)
    {
        $key = sprintf(config('site.latest_counts_lotteries_key'),$game_id);
        $value = Redis::get($key);
        if(!$value) {
            $sql = 'SELECT DISTINCT `g_key`, `g_value`, COUNT(`id`) AS counts FROM `game_lottery_infos`
                WHERE `game_id` = ? AND `issue` IN (
                    SELECT * FROM(	
                        SELECT `issue` FROM `game_lotteries` WHERE `game_id` = ? ORDER BY `issue` DESC LIMIT ?
                    ) AS issues
                ) 
                GROUP BY `g_key`, `g_value`
                HAVING counts > 1
                ORDER BY counts DESC LIMIT ? ';
            $result = \DB::select($sql, [$game_id, $game_id, $issueLimit, $countsLimit]);
            $value = json_encode($result);
            Redis::set($key, $value);

        }
        return json_decode($value,TRUE);
    }
}
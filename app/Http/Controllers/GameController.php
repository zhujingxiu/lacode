<?php

namespace App\Http\Controllers;

use App\Repositories\GameRepository;
use App\Repositories\MemberRepository;
use DB;
use Illuminate\Http\Request;

class GameController extends Controller
{
    //
    public function games()
    {

        GameRepository::lotteryCounts(5);
        $games = MemberRepository::memberGames();
        return ajax_return(1,compact('games'));
    }

    public function group(Request $request)
    {
        $group_id = $request->get('group');
        $group = GameRepository::gameGroup($group_id);
        $game_id = $group['game_id'];
        $opening = GameRepository::openingIssue($game_id);
        if(!$opening){
            return ajax_return(0);
        }
        $game = GameRepository::game($game_id);
        return ajax_return(1,compact('group','game'));
    }

    public function lastIssue(Request $request)
    {
        $game_id = $request->get('game');
        $last = GameRepository::lastIssue($game_id);
        return ajax_return(1, $last);
    }

    public function opening(Request $request)
    {
        $game_id = $request->get('game');
        $opening = GameRepository::openingIssue($game_id);
        if(!$opening){
            return ajax_return(0);
        }
        $issue = $opening['issue'];
        $open = strtotime($opening['open_time']) - time();
        $end = max(strtotime($opening['end_time']) - time(),0);
        $interval = ($open >0 && $open < 90 ) ? $open : 90;
        return ajax_return(1,compact('issue','interval','open','end'));
    }

    public function odds(Request $request)
    {
        $group_id = $request->get('group');
        $gameOdds = GameRepository::groupOdds($group_id);
        $member = MemberRepository::me();
        $member->load('info');
        $odds = $gameOdds[$member->info->roulette];
        return ajax_return(1, $odds);
    }

    public function latest(Request $request)
    {
        $game_id = $request->get('game');
        $latest = GameRepository::latestLotteries($game_id);
        $issues = [];
        foreach ($latest as $item){
            $_issue = json_decode($item, TRUE);
            $issues[$_issue['issue']] = array_values($_issue['numbers']);
        }
        return ajax_return(1,$issues);
    }

    public function counts(Request $request)
    {
        $game_id = $request->get('game');
        $counts = GameRepository::lotteryCounts($game_id);
        $tmp=[];
        $double_keys = [
            'daxiao','danshuang','long','hu','he'
        ];
        foreach ($counts as $item){
            $option = '';
            foreach ($double_keys as $key){
                $index = stripos($item['g_key'],$key);
                if($index!==FALSE){
                    $option = trim(substr($item['g_key'], 0, $index),'_');
                    break;
                }
            }

            $tmp[] = [
                'title'=> __('lottery.'.$option).' - '.__('lottery.'.$item['g_value']),
                'count'=> $item['counts'],
                'option'=> $option
            ];
        }
        return ajax_return(1, $tmp);
    }

}

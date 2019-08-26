<?php

namespace App\Http\Controllers\Merchant;

use App\Libs\Game\Models\Game;
use App\Libs\Game\Models\GameGroupOption;
use App\Libs\Game\Models\GameOdds;
use App\Libs\Game\Models\GameLottery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    // 系统设置
    public function index()
    {
        return view('merchant.config.index');
    }
    // 赔率设置
    public function odds(Request $request)
    {
        if($request->isMethod('post')){
            $game_id = $request->input('game');
            $odds = $request->input('odds');
            $game = Game::find($game_id);
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
            $lottery = \App::make($game_class, ['game' => $game]);
            $ret = $lottery->defaultOdds($odds);


            return ajax_return(1);
        }
        if($request->isXmlHttpRequest()){
            $game_id = $request->get('game');
            $game = Game::find($game_id);

            foreach ($game->groups as $key=>$group){
                $game_options = GameGroupOption::where('group_id',$group->id)->with('option')->get();
                foreach ($game_options as $_key => $item){
                    $option_odds = GameOdds::where(['group_id'=>$group->id,'option_id'=>$item->option_id])->whereIn('roulette',['a','d'])->with('bet')->get()->groupBy('roulette');
                    $game_options[$_key]['odds'] = $option_odds;
                }
                $game->groups[$key]['options'] = $game_options;
            }

            //dd($game);
            return ajax_return(1,[
                'game'=>$game,
                'title'=>$game->title,
                'tpl' => response(view('merchant.config.odds_game', compact( 'game')))->getContent()
            ]);
        }
        $games = Game::where('status', 1)->get();
        $game = $games->first();
        return view('merchant.config.odds',compact('games','game'));
    }
    // 赔率差
    public function oddsDiff(Request $request)
    {
        if($request->isMethod('post')){
            $options = $request->input('option');
            foreach ($options as $game_id => $option_sets){
                $tmp = [];
                foreach ($option_sets as $option_id => $diff){
                    $tmp[] = array_merge($diff,['id'=>$option_id]);
                }
                if($tmp) {

                    $game = Game::find($game_id);
                    $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
                    $lottery = \App::make($game_class, ['game' => $game]);
                    $ret = $lottery->updateOption('id',$tmp);

                }
            }
            return ajax_return(1);
        }

        $games = Game::where('status', 1)->with('options')->get();
        return view('merchant.config.odds_diff',compact('games'));
    }
    // 开奖设置
    public function lottery(Request $request)
    {
        if($request->isMethod('post')){
            $game_id = $request->input('game');
            $game = Game::find($game_id);
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
            $lottery = \App::make($game_class, ['game' => $game]);
            $action = $request->input('action');
            switch ($action){
                case 'delete':
                    $ret = $lottery->deleteIssue($request->input('issue'));
                    break;
                case 'clear':
                    $ret = $lottery->clearIssues($request->input('day'));
                    break;
                case 'modify':
                    $ret = $lottery->modifyIssue($request->except(['_token']));
                    break;
                case 'resettle':
                    $ret = $lottery->resettleIssue($request->input('issue'));
            }
            $redirect = route('merchant.config-lottery');
            return ajax_return($ret, compact('redirect'));
        }
        $game_id = $request->get('game');
        if($game_id){
            $game = Game::find($game_id);
        }else{
            $game = Game::where('status', 1)->first();
        }

        $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
        $lottery = \App::make($game_class, ['game' => $game]);

        $options = $lottery->lotteryOption();
        $openNumbers = $options['numbers'];
        $lotteries = GameLottery::where(['game_id'=>$game->id])->orderBy('issue','desc')->paginate(20);


        return view('merchant.config.lottery', compact('lotteries','game','openNumbers'));
    }
    // 开盘设置
    public function schedule(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $game_id = $request->get('game');
            $game = Game::find($game_id);

            $game->load(['schedules','schedule_issues'=>function($query){
                $query->where([['status','!=','-1']]);
            }]);

            //dd($game);
            return ajax_return(1,[
                'game'=>$game,
                'title'=>$game->title,
                'tpl' => response(view('merchant.config.schedule_game', compact( 'game')))->getContent()
            ]);
        }
        $games = Game::where('status', 1)->get();
        $game = $games->first();
        return view('merchant.config.schedule',compact('games','game'));
    }
    // 退水设置
    public function rebate(Request $request)
    {
        if($request->isMethod('post')){
            $rebates = $request->input('rebate');
            foreach ($rebates as $game_id => $trait_rebates){
                $tmp = [];
                foreach ($trait_rebates as $trait => $rebate){
                    foreach ($rebate as $key=>$value){
                        $tmp[] = [
                            'trait'=>$trait,
                            'g_key'=>$key,
                            'g_value'=>$value,
                        ];
                    }
                }
                if($tmp) {
                    $game = Game::find($game_id);
                    $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
                    $lottery = \App::make($game_class, ['game' => $game]);
                    $lottery->rebates($tmp);
                }
            }
            return ajax_return(1);
        }
        $games = Game::where('status', 1)->with('rebates')->get();
        foreach ($games as $key => $game) {
            $games[$key]->rebates = $game->rebates->groupBy('trait')->transform(function ($item, $key) {
                $tmp= [];
                foreach ($item as $_trait){
                    $tmp[$_trait->g_key]=$_trait->g_value;
                }
                return $tmp;
            })->toArray();
        }
        return view('merchant.config.rebate',compact('games'));
    }

    public function store()
    {

    }
}

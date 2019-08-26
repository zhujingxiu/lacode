<?php

namespace App\Admin\Controllers;

use App\Libs\Game\Models\Game;
use App\Libs\Game\Models\GameSchedule;
use App\Libs\Game\Models\GameGroup;
use App\Libs\Game\Models\GameOption;
use App\Libs\Game\Models\GameBet;
use App\Libs\Game\Models\GameOdds;
use \DB;
class GameController extends Controller
{
    public function index()
    {
        $page_title = '彩种管理';
        $games = Game::paginate(10);
        return view('admin.game.index', compact('page_title', 'games'));
    }

    public function store()
    {

    }

    public function delete(Game $game)
    {
        $game->status = 0;
        $game->save();
    }

    public function install(Game $game)
    {
        $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));

        $lottery = \App::make($game_class, ['game' => $game]);
        $ret = $lottery->install();
        return ajax_return($ret,sprintf('彩种【%s】安装成功，并已经激活', $game->title), '彩种安装成功');
    }

    public function uninstall(Game $game)
    {
        $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));

        $lottery = \App::make($game_class, ['game' => $game]);
        $ret = $lottery->uninstall();
        return ajax_return($ret,sprintf('彩种【%s】已卸载', $game->title,'彩种卸载成功'));
    }
    public function bets(Game $game)
    {
        if (\Request::isMethod('post')) {
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));

            $lottery = \App::make($game_class, ['game' => $game]);
            $default = \Request::input('default');
            $input = \Request::input('bet');
            if(!$default && !$input){
                return ajax_return(0, '彩种【'.$game->title.'】彩注更新失败','参数异常');
            }
            $ret = $lottery->bets($input, $default);
            return ajax_return($ret, '彩种【'.$game->title.'】彩注更新'.($ret ? '成功' : '失败'));
        }
        $bets = $game->bets;

        return ajax_return(1,[
            'title' => '彩注设定-'.$game->title,
            'tpl' => response(view('admin.game.bet', compact('bets', 'game')))->getContent()
        ]);
    }

    public function options(Game $game)
    {
        if (\Request::isMethod('post')) {
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));

            $lottery = \App::make($game_class, ['game' => $game]);
            $default = \Request::input('default');
            $input = \Request::input('option');
            if(!$default && !$input){
                return ajax_return(0, '彩种【'.$game->title.'】彩标更新失败','参数异常');
            }
            $ret = $lottery->options($input, $default);
            return ajax_return($ret,'彩种【'.$game->title.'】彩标更新'.($ret ? '成功' : '失败'));
        }
        $options = $game->options;
        $traits = GameOption::getTraits();
        return ajax_return(1, [
                'title' => '彩标设定-'.$game->title,
                'tpl' => response(view('admin.game.option', compact('options', 'game','traits')))->getContent()
            ]);
    }

    public function rebates(Game $game)
    {
        if (\Request::isMethod('post')) {
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));

            $lottery = \App::make($game_class, ['game' => $game]);
            $default = \Request::input('default');
            $input = \Request::input('rebate');
            $data=[];
            if(!$default && !$input){
                return ajax_return(0, '彩种【'.$game->title.'】默认退水更新失败','参数异常');
            }else if($input){
                foreach ($input as $trait=>$rebate){
                    foreach ($rebate as $key=>$value){
                        $data[] = [
                            'trait' => $trait,
                            'g_key' => $key,
                            'g_value' => $value,
                        ];
                    }
                }
            }
            $ret = $lottery->rebates($data,$default);
            return ajax_return($ret,'彩种【'.$game->title.'】默认退水更新'.($ret ? '成功' : '失败'));
        }
        $rebates = $game->rebates()->orderBy('sort')->orderBy('id')->groupBy('trait')->transform(function ($item, $key) {
            $tmp= [];
            foreach ($item as $_bet){
                $tmp[$_bet->g_key]=$_bet->g_value;
            }
            return $tmp;
        })->toArray();
        $traits = GameOption::getTraits();
        return ajax_return(1, [
            'title' => '退水设定-'.$game->title,
            'tpl' => response(view('admin.game.rebate', compact('rebates', 'game','traits')))->getContent()
        ]);
    }

    public function groups(Game $game)
    {
        if (\Request::isMethod('post')) {
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
            $lottery = \App::make($game_class, ['game' => $game]);
            $default = \Request::input('default');
            $input = \Request::input('group');
            if(!$default && !$input){
                return ajax_return(0,'彩种【'.$game->title.'】彩盘更新失败');
            }
            $ret = $lottery->groups($input,$default);
            return ajax_return($ret,'彩种【'.$game->title.'】彩盘更新'.($ret ? '成功' : '失败'));
        }
        $groups = $game->groups;
        return ajax_return(1,[
                'title' => '彩盘设定-'.$game->title,
                'tpl' => response(view('admin.game.group', compact('groups', 'game')))->getContent()
            ]);
    }

    /*
     * 开盘列表
     */
    public function schedules(Game $game)
    {
        if (\Request::isMethod('post')) {
            $schedule_id = \Request::input('schedule');
            $fields = \Request::only(['start_time','total','interval','ahead','sort','status']);
            if($schedule_id){
                if(!isset($fields['status'])){
                    $fields['status'] =0 ;
                }
            }else{
                $fields['game_id'] = $game->id;
                $fields['status'] = 1;
            }
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
            $lottery = \App::make($game_class, ['game' => $game]);
            $lottery->schedule($fields, $schedule_id);
            return ajax_return(1, '彩种【'.$game->title.'】开盘时段修改成功');
        }
        if(\Request::ajax()) {
            DB::enableQueryLog();
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
            $lottery = \App::make($game_class, ['game' => $game]);
            $ret = $lottery->resetSchedules($game->schedules->toArray());

            return ajax_return($ret, '重载【' . $game->title . '】盘口' . ($ret ? '成功' : '失败'));
        }
        $page_title = '开盘设置-'.$game->title;
        $game->load(['schedules','schedule_issues'=>function($query){
            $query->where([['status','!=','-1']]);
        }]);
        $games = Game::where('status',1)->get();
        return view('admin.game.schedule', compact('page_title', 'game','games'));
    }

    public function odds(Game $game)
    {
        $page_title = '赔率设置-'.$game->title;
        $options = $game->options;
        $groups = $game->groups;
        $odds_options = $game->odds_options->groupBy('group_id')->transform(function ($item, $key) {
            $tmp= [];
            foreach ($item as $_option){
                $tmp[$_option->option_id]=$_option;
            }
            return $tmp;
        })->toArray();
        $games = Game::where('status',1)->get();
        return view('admin.game.odds',compact('page_title','game','games','options','groups','odds_options'));
    }

    public function optionBets(Game $game)
    {
        if (\Request::isMethod('post')) {
            $bets = \Request::input('bet');
            $group_id = \Request::input('group_id');
            $option = \Request::input('option');
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
            $lottery = \App::make($game_class, ['game' => $game]);
            $ret = $lottery->odds($group_id,$option,$bets);
            return ajax_return($ret, '彩种【'.$game->title.'】默认赔率修改'.($ret ? '成功':'失败'));
        }
        //彩注
        $bets = $game->bets;
        //过滤参数
        $option_id = \Request::input('option');
        $copy_option_id = \Request::input('copy_option');
        $option = GameOption::find($option_id);

        $group_id = \Request::input('group');
        $copy_group_id = \Request::input('copy_group');
        $group = GameGroup::find($group_id);
        // 获取自己的或复制其他的
        $odds_bets = GameOdds::where(['option_id'=>$copy_option_id ? $copy_option_id : $option_id,'group_id'=>$copy_group_id ? $copy_group_id :$group_id])->get()->groupBy('bet_id')->transform(function ($item, $key) {
            $tmp= [];
            foreach ($item as $_bet){
                $tmp[$_bet->roulette]=$_bet->g_value;
            }
            return $tmp;
        })->toArray();

        $otherOddsOptions = [];
        foreach ($game->groups as $_group){
            $otherOddsOptions[] = $_group->oddsOptions()->with('option','group')->get();
        }
       // dd($otherOddsOptions);
        return ajax_return(1, [
                'title'=> '当前彩标:'. $option->title,
                'tpl' => response(view('admin.game.option_bets', compact('bets', 'game','group','option','odds_bets','otherOddsOptions')))->getContent()
            ]);
    }
}

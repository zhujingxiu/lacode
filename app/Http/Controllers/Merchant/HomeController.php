<?php

namespace App\Http\Controllers\Merchant;

use App\Libs\Game\Models\Game;
use App\Libs\Game\Models\GameLottery;
use App\Libs\Game\Models\GameLotteryInfo;
use App\Libs\Merchant\Models\Merchant;
use App\Libs\Merchant\Models\Member;
use App\Libs\Merchant\Models\MerchantHistory;
use App\Libs\Merchant\Models\MerchantLog;
use App\Models\Notice;
use App\Models\SystemRole;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public $guard = 'merchant';
    public function index()
    {
        $page_title = '商户后台首页';

        return view($this->guard.'.home.index', compact('page_title'));
    }

    public function online(Request $request)
    {
        $count = [];
        $admin_role  =SystemRole::select('id')->where(['role'=>'merchant','code'=>'admin'])->first();
        $count['admin'] = Merchant::where(['online'=>1,'role_id'=>$admin_role->id])->count();
        $company_role  =SystemRole::select('id')->where(['role'=>'merchant','code'=>'company'])->first();
        $count['company'] = Merchant::where(['online'=>1,'role_id'=>$company_role->id])->count();
        $shareholder_role  =SystemRole::select('id')->where(['role'=>'merchant','code'=>'shareholder'])->first();
        $count['shareholder'] = Merchant::where(['online'=>1,'role_id'=>$shareholder_role->id])->count();
        $agent_role  =SystemRole::select('id')->where(['role'=>'merchant','code'=>'agent'])->first();
        $count['agent'] = Merchant::where(['online'=>1,'role_id'=>$agent_role->id])->count();
        $proxy_role  =SystemRole::select('id')->where(['role'=>'merchant','code'=>'proxy'])->first();
        $count['proxy'] = Merchant::where(['online'=>1,'role_id'=>$proxy_role->id])->count();
        $count['member'] = Member::where(['online'=>1])->count();


        $role = $request->get('role','member') ;
        switch ($role){
            case 'member':
                $records = Member::where(['online'=>1])->with(['info','merchant','merchant.role'])->paginate($this->per_page);
                break;
            default:
                $records = Merchant::where(['online'=>1,'role_id'=>${$role."_role"}->id])->with(['info','role'])->paginate($this->per_page);
        }
        foreach ($records as $key => $record){
            $record->history = MerchantLog::where(['user_id'=>$record->id,'role'=>$role=='member'?'member':'merchant'])->orderBy('created_at','desc')->first();
            $records[$key] = $record;
        }
        return view($this->guard.'.home.online', compact('count','role','records'));
    }

    public function notice()
    {
        $notices = Notice::orderBy('updated_at','desc')->paginate(20);
        return view($this->guard.'.home.notice', compact('notices'));
    }

    public function lottery(Request $request)
    {
        $game_id = $request->get('game');
        if($game_id){
            $game = Game::find($game_id);
        }else{
            $game = Game::where('status', 1)->first();
        }
        $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
        $lottery = \App::make($game_class, ['game' => $game]);
        $options = $lottery->lotteryOption();
        $lotteries = GameLottery::select(['game_id','issue','open_time'])->where(['game_id'=>$game->id])->orderBy('issue','desc')->paginate(20);
        foreach ($lotteries as $key => $lottery){
            $items = GameLotteryInfo::where(['game_id'=>$game->id,'issue'=>$lottery->issue])->get();
            foreach ($items as $item){
                $lotteries[$key]->{$item['g_key']} = $item['g_value'];
            }
        }

        return view($this->guard.'.home.lottery', compact('lotteries','game','options'));
    }

}

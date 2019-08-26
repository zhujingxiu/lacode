<?php

namespace App\Admin\Controllers;

use App\Admin\Requests\FormMember;

use App\Libs\Game\Models\Game;
use App\Libs\Merchant\Models\Member;
use App\Libs\Merchant\Models\MemberInfo;
use App\Libs\Merchant\Models\Merchant;
use App\Models\SystemRole;

class MemberController extends Controller
{
    /*
     * 用户列表
     */
    public function index()
    {

        $page_title = '会员管理';
        return view('admin.member.index', compact('page_title'));
    }
    public function listData()
    {
        $rows = [];
        $where = [];
        if(!empty(\Request::input('username'))){
            $where[] = ['username','like',\Request::input('username').'%'];
        }
        if(!empty(\Request::input('nickname'))){
            $where[] = ['nick_name','like',\Request::input('nickname').'%'];
        }
        if(\Request::input('status')!='*'){
            $where[] = ['status', \Request::input('status')];
        }
        if(!empty(\Request::input('startdate'))){
            $where[] = ['created_at','>=', \Request::input('startdate')];
        }
        //dd($where);
        $total = Member::where($where)->count();
        $members = Member::where($where)->with(['info','merchant'])->paginate(20);
        foreach ($members as $member){
            if($member->merchant->role->code=='proxy'){
                $role_code = '普通会员';
            }else{
                $role_code = sprintf('直属%s会员', $member->merchant->role->code);
            }

            $rows[] = [
                'mid' => $member->id,
                'name' => $member->name,
                'nickname' => $member->nick_name,
                'merchant_role' => $role_code,
                'merchant' => $member->merchant->name,
                'roulette' => $member->info->roulette,
                'rate' => $member->info->rate,
                'balance' => $member->info->balance,
                'online' => $member->online,
                'status' => $member->status,
                'joined' => $member->created_at->format('Y-m-d'),
                'rebate_link' => route('admin.member-rebates', $member)
            ];
        }
        return ['error_code'=>0,'rows'=>$rows,'total'=>$total];
    }
    /*
     * 创建用户
     */
    public function create()
    {
        $merchants = Merchant::whereNotIn('status',[0])->whereNotIn('role_id',SystemRole::whereIn('code',['admin'])->pluck('id'))->with(['info','role'])->get();
        $role_merchants = $merchants->groupBy('role.code');
        $rebatesOptions = MemberInfo::rebatesOptions();
        return ajax_return(1, [
            'title' => '添加会员',
            'tpl' => response(view('admin.member.new', compact('role_merchants', 'rebatesOptions')))->getContent()
        ]);
    }

    /*
     * 创建用户
     */
    public function store(FormMember $request)
    {
        $member_class = sprintf('%s\Member', config('site.merchant_namespace'));
        $member = \App::make($member_class,['code'=>$request->input('code')]);
        $ret = $member->addNew($request->except('_token'));
        return ajax_return($ret,['redirect'=>route('admin.member-rebates',$ret)]);
    }

    public function disabled()
    {

    }

    public function rebates(Member $member)
    {
        if (\Request::isMethod('post')) {
            $member_class = sprintf('%s\Member', config('site.merchant_namespace'));
            $member_instance = \App::make($member_class);
            $input = \Request::input('rebate');
            if(!$input){
                return ajax_return(0,'退水设置更新失败');
            }
            $ret = $member_instance->rebates($member->id,$input);
            return ajax_return($ret,'退水设置更新'.($ret ? '成功' : '失败'));
        }
        $page_title = '退水设置-'.$member->nick_name;
        $games = Game::where('status', 1)->with(['options','rebates'])->get();
        foreach ($games as $key => $game) {
            $games[$key]->rebates = $game->rebates->groupBy('trait')->transform(function ($item, $key) {
                $tmp= [];
                foreach ($item as $_trait){
                    $tmp[$_trait->g_key]=$_trait->g_value;
                }
                return $tmp;
            })->toArray();
        }
        $member->load(['merchant','rebates'=>function($query){
            $query->where('role','member');
        }]);
        $member_rebates = [];
        if($member->rebates){
            foreach ($member->rebates as $rebate) {
                $member_rebates[$rebate->option_id][$rebate->g_key] = $rebate->g_value;
            }
        }
        if(!$member_rebates){
            $member->load(['merchant.rebates'=>function($query){
                $query->where('role','merchant');
            }]);
            foreach ($member->merchant->rebates as $rebate) {
                $member_rebates[$rebate->option_id][$rebate->g_key] = $rebate->g_value;
            }
        }
        return view('admin.member.rebate', compact('page_title','member','member_rebates','games'));
    }
}
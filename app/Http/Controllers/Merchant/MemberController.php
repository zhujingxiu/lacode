<?php

namespace App\Http\Controllers\Merchant;

use App\Libs\Game\Models\Game;
use App\Libs\Merchant\Models\Merchant;
use App\Libs\Merchant\Models\Member;
use App\Libs\Merchant\Models\MerchantRelation;
use App\Libs\Merchant\Models\MerchantHistory;
use App\Models\SystemRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormMember;
use App\Models\LoginLog;
class MemberController extends Controller
{
    //
    public $per_page = 10;
    public function index(Request $request)
    {
        $query =  Member::query();
        $filter_url = url()->current();
        if($request->has('status')){
            $query->where('status',(int)$request->get('status'));
        }
        if($request->has('name')){
            $query->where('name','like',$request->get('name').'%');
        }
        if($request->has('nick_name')){
            $query->where('nick_name','like',$request->get('nick_name').'%');
        }
        $merchant = $request->get('merchant');
        if($merchant){
            $filter_url .='?merchant='.$merchant;
            $parent=Merchant::where('name',$merchant)->first();
            if(isset($parent->id) ) {
                $_ids = MerchantRelation::where(['merchant_id'=>$parent->id,'child_role'=>'member'])->pluck('user_id');
                if ($_ids) {
                    $query->whereIn('id', $_ids);
                } else {
                    $query->where('id', 0);
                }
            }else{
                $query->where('id', 0 );
            }
        }
        $members = $query->with(['merchant','merchant.role','merchant.info','info'])->paginate($this->per_page);
        return view('merchant.member.index',compact('filter_url','parent','members'));
    }

    public function create(Request $request)
    {
        $rel = $request->get('rel');
        $code = $rel ? 'company' : 'proxy';
        return view('merchant.member.create',compact('code'));
    }

    public function merchants(Request $request)
    {
        $code = $request->get('role');
        $role = SystemRole::where('code',$code)->first();
        $merchants = Merchant::where([['status','<>',0],['role_id',$role->id]])->with('info')->get();
        return ajax_return(1, compact('merchants'));
    }

    public function merchant(Request $request)
    {
        $merchant = Merchant::where('id',$request->get('merchant'))->with('info')->firstOrFail();
        return ajax_return(1, compact('merchant'));
    }

    public function check(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('name');
        $query = Member::query();
        $query->where('name',$name);
        if($id){
            $query->where('id','<>', $id);
        }
        $exists = $query->first();
        if($exists){
            return ajax_return(0);
        }else{
            return ajax_return(1);
        }

    }
    public function store(FormMember $request)
    {
        $member_class = sprintf('%s\Member', config('site.merchant_namespace'));
        $member = \App::make($member_class,['code'=>$request->input('code')]);
        $member_id = $member->addNew($request->except('_token'));
        $redirect = route('merchant.member');
        return ajax_return($member_id,['redirect'=>$redirect]);
    }

    public function rebate(Member $member, Request $request)
    {
        if($request->isMethod('post')){
            $code = $member->merchant->role->code;
            $member_class = sprintf('%s\Member', config('site.merchant_namespace'));
            $memberRole = \App::make($member_class,['code'=>$code]);
            $ret = $memberRole->rebates($member->id, $request->input('rebate'));
            return ajax_return($ret);
        }
        $games = Game::where('status', 1)->with(['options'])->get();

        $member->load(['info','rebates'=>function($query){
            $query->where('role','member');
        }]);
        $member_rebates = $merchant_rebates =  [];
        foreach($member->rebates as $rebate){
            $member_rebates[$rebate->option_id][$rebate->g_key] = $rebate->g_value;
        }
        $merchant = Merchant::find($member->merchant_id);
        $merchant->load(['rebates'=>function($query){
            $query->where('role','merchant');
        }]);
        foreach($merchant->rebates as $rebate){
            $merchant_rebates[$rebate->option_id][$rebate->g_key] = $rebate->g_value;
        }
        return view('merchant.member.rebate', compact('member','merchant_rebates','member_rebates','games'));
    }

    public function log(Member $member)
    {
        $logs = LoginLog::where(['role'=>'member','uid'=>$member->id])->paginate($this->per_page);
        return view('merchant.member.log',compact('member','logs'));
    }

    public function history(Member $member)
    {
        $histories = MerchantHistory::where(['role'=>'member','user_id'=>$member->id])->with('merchant')->paginate($this->per_page);
        return view('merchant.member.history',compact('member','histories'));
    }

    public function recharge(Member $member,Request $request)
    {
        if($request->isMethod('post')){
            $balance = $request->input('balance');
            if(!is_numeric($balance)){
                return ajax_return(0);
            }
            $code = $member->merchant->role->code;
            $member_class = sprintf('%s\Member', config('site.merchant_namespace'));
            $memberRole = \App::make($member_class,['code'=>$code]);
            $ret = $memberRole->recharge($member->id, $balance);
            $redirect = route('merchant.member-recharge',$member);
            return ajax_return($ret,compact('redirect'));
        }
        $member->load('info');
        return view('merchant.member.recharge',compact('member'));
    }
}

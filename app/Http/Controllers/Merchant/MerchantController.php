<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Requests\FormMerchant;
use App\Libs\Game\Models\Game;
use App\Libs\Merchant\Models\Merchant;
use App\Libs\Merchant\Models\MerchantHistory;
use App\Libs\Merchant\Models\MerchantLog;
use App\Libs\Merchant\Models\MerchantRelation;
use App\Libs\Merchant\Role\Member;
use App\Libs\Merchant\Role\MerchantCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SystemRole;
use App\Models\LoginLog;
class MerchantController extends Controller
{
    //
    public $per_page = 10;
    public function company(Request $request)
    {
        $role = SystemRole::where('code', 'company')->firstOrFail();
        $query = Merchant::query();
        if($request->has('status')){
            $query->where('status',(int)$request->get('status'));
        }
        if($request->has('name')){
            $query->where('name','like',$request->get('name').'%');
        }
        if($request->has('nick_name')){
            $query->where('nick_name','like',$request->get('nick_name').'%');
        }
        $merchants = $query->where('role_id', $role->id)->with(['info'])->withCount([
            'referralShareholders as shareholder_count'=>function($query){
                $query->where('child_role','shareholder');
            },
            'referralAgents as agent_count'=>function($query){
                $query->where('child_role','agent');
            },
            'referralProxies as proxy_count'=>function($query){
                $query->where('child_role','proxy');
            },
            'referralMembers as member_count'=>function($query){
                $query->where('child_role','member');
            },
        ])->paginate($this->per_page);

        $filter_url = url()->current();

        return view('merchant.merchant.company', compact('role', 'merchants','filter_url'));
    }

    public function shareholder(Request $request)
    {
        $filter_url = url()->current();
        $role = SystemRole::where('code', 'shareholder')->firstOrFail();
        $query = Merchant::query();
        if($request->has('status')){
            $query->where('status',(int)$request->get('status'));
        }
        if($request->has('name')){
            $query->where('name','like',$request->get('name').'%');
        }
        if($request->has('nick_name')){
            $query->where('nick_name','like',$request->get('nick_name').'%');
        }
        $parent = $request->get('parent');
        if($parent){
            $filter_url .='?parent='.$parent;
            $parent=Merchant::where('name',$parent)->first();
            $query->where('parent_id', empty($parent->id) ? -1 : $parent->id);
        }
        $merchants = $query->where('role_id',$role->id)->with(['info','parent','parent.info'])->withCount([

            'referralAgents as agent_count'=>function($query){
                $query->where('child_role','agent');
            },
            'referralProxies as proxy_count'=>function($query){
                $query->where('child_role','proxy');
            },
            'referralMembers as member_count'=>function($query){
                $query->where('child_role','member');
            },
        ])->paginate($this->per_page);

        return view('merchant.merchant.shareholder', compact('role','merchants','filter_url'));
    }

    public function agent(Request $request)
    {
        $filter_url = url()->current();
        $role = SystemRole::where('code', 'agent')->firstOrFail();
        $query = Merchant::query();
        if($request->has('status')){
            $query->where('status',(int)$request->get('status'));
        }
        if($request->has('name')){
            $query->where('name','like',$request->get('name').'%');
        }
        if($request->has('nick_name')){
            $query->where('nick_name','like',$request->get('nick_name').'%');
        }
        $parent = $request->get('parent');
        if($parent){
            $filter_url .='?parent='.$parent;
            $parent=Merchant::where('name',$parent)->first();
            if(isset($parent->id)){
                $_ids = MerchantRelation::where(['merchant_id'=>$parent->id,'child_role'=>'agent'])->pluck('user_id');
                if($_ids){
                    $query->whereIn('id', $_ids);
                }else{
                    $query->where('id', 0);
                }
            }else{
                $query->where('id', 0 );
            }
        }
        $merchants = $query->where('role_id',$role->id)->with(['parent','info'])->withCount([
            'referralProxies as proxy_count'=>function($query){
                $query->where('child_role','proxy');
            },
            'referralMembers as member_count'=>function($query){
                $query->where('child_role','member');
            },
        ])->paginate($this->per_page);


        return view('merchant.merchant.agent', compact('role','merchants','filter_url'));
    }

    public function proxy(Request $request)
    {
        $filter_url = url()->current();
        $role = SystemRole::where('code', 'proxy')->firstOrFail();
        $query = Merchant::query();
        if($request->has('status')){
            $query->where('status',(int)$request->get('status'));
        }
        if($request->has('name')){
            $query->where('name','like',$request->get('name').'%');
        }
        if($request->has('nick_name')){
            $query->where('nick_name','like',$request->get('nick_name').'%');
        }
        $parent = $request->get('parent');
        if($parent){
            $filter_url .='?parent='.$parent;
            $parent=Merchant::where('name',$parent)->first();
            if(isset($parent->id) ) {
                $_ids = MerchantRelation::where(['merchant_id'=>$parent->id,'child_role'=>'proxy'])->pluck('user_id');
                if ($_ids) {
                    $query->whereIn('id', $_ids);
                } else {
                    $query->where('id', 0);
                }
            }else{
                $query->where('id', 0 );
            }
        }
        $merchants = $query->where('role_id', $role->id)->with(['parent','info'])->withCount('children as member_count')->paginate(10);
        return view('merchant.merchant.proxy', compact('role','merchants','filter_url'));
    }

    public function admin(Request $request)
    {
        $code = 'admin';
        if($request->isMethod('post')){

            $this->validate($request, [
                'name' => 'required|unique:merchants,name|max:32'
            ]);
            $merchant_class = sprintf('%s\Merchant%s', config('site.merchant_namespace'), ucwords($code));
            $merchantRole = \App::make($merchant_class,['code'=>$code]);
            $name = $request->input('name');
            $merchant_id = $merchantRole->addNew([
                'name'=> $name,
                'nick_name'=> $name,
                'password'=> $name,
            ]);
            $redirect = route('merchant.user-'.$code);
            return ajax_return(1,compact('redirect'));
        }
        $role = SystemRole::where(['code'=> $code,'role'=>'merchant'])->firstOrFail();
        $admins = Merchant::where(['role_id'=>$role->id])->paginate($this->per_page);
        return view('merchant.merchant.admin', compact('role','admins'));
    }

    public function create($code)
    {
        $role = SystemRole::where('code', $code)->firstOrFail();
        $merchants = [];
        $parent_role = $rate_company = $charges =$replenish = $order_now = $rate_remain= FALSE;
        if(!in_array($code, ['company'])){
            $replenish = TRUE;
            $parent_role = $role->parentMerchantRole();
        }else{
            $rate_company = TRUE;
            $charges = TRUE;
        }
        if(in_array($code,['agent','proxy'])){
            $rate_remain = TRUE;
        }
        if(in_array($code,['proxy'])){
            $order_now = TRUE;
        }
        return view('merchant.merchant.create',compact('parent_role','role','merchants','rate_remain','replenish','order_now','rate_company','charges'));
    }

    public function check(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('name');
        $query = Merchant::query();
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

    public function store(FormMerchant $request)
    {
        $code = $request->input('code');
        $merchant_class = sprintf('%s\Merchant%s', config('site.merchant_namespace'), ucwords($code));
        $merchantRole = \App::make($merchant_class,['code'=>$code]);
        $merchant_id = $merchantRole->addNew($request->except('_token'));
        $redirect = route('merchant.user-'.$code);
        return ajax_return($merchant_id,compact('redirect'));
    }

    public function rebate(Merchant $merchant, Request $request)
    {
        if($request->isMethod('post')){
            $code = $merchant->role->code;
            $merchant_class = sprintf('%s\Merchant%s', config('site.merchant_namespace'), ucwords($code));
            $merchantRole = \App::make($merchant_class,['code'=>$code]);
            $ret = $merchantRole->rebates($merchant->id, $request->input('rebate'));
            return ajax_return($ret);
        }
        $games = Game::where('status', 1)->get();
        foreach ($games as $key => $game) {
            $games[$key]->rebates = $game->rebates->groupBy('trait')->transform(function ($item, $key) {
                $tmp= [];
                foreach ($item as $_trait){
                    $tmp[$_trait->g_key]=$_trait->g_value;
                }
                return $tmp;
            })->toArray();
        }
        $merchant->load(['role','rebates'=>function($query){
            $query->where('role','merchant');
        }]);
        $merchant_rebates = $parent_rebates = [];
        foreach($merchant->rebates as $rebate){
            $merchant_rebates[$rebate->option_id][$rebate->g_key] = $rebate->g_value;
        }
        if($merchant->role->code=='company'){
            $games->load(['rebates','options']);
            $merchant->load('rebates.option');
            foreach ($games as $game) {
                foreach($merchant->rebates as $rebate){
                    $_trait = $rebate->option->trait;
                    $_game_rebates = $game->rebates[$_trait];
                    if(!$game->options->groupBy('id')->has($rebate->option_id)){
                        continue;
                    }
                    foreach ($_game_rebates as $key=>$value){
                        $parent_rebates[$rebate->option_id][$key] = $value;
                    }

                }
            }
        }else {
            $parent_merchant = Merchant::find($merchant->parent_id);
            $parent_merchant->load(['rebates' => function ($query) {
                $query->where('role', 'merchant');
            }]);
            foreach ($parent_merchant->rebates as $rebate) {
                $parent_rebates[$rebate->option_id][$rebate->g_key] = $rebate->g_value;
            }
        }
        return view('merchant.merchant.rebate', compact('merchant','parent_rebates','merchant_rebates','games'));
    }

    public function edit(Merchant $merchant)
    {
        $merchant->load('role');
        $code = $merchant->role->code;
        $parent_role = $rate_company = $charges =$replenish = $order_now = $rate_remain= FALSE;
        if(!in_array($code, ['company'])){
            $replenish = TRUE;
            $parent_role = TRUE;
            $merchant->load(['parent','parent.info','parent.role']);
        }else{
            $rate_company = TRUE;
            $charges = TRUE;
        }
        if(in_array($code,['agent','proxy'])){
            $rate_remain = TRUE;
        }
        if(in_array($code,['proxy'])){
            $order_now = TRUE;
        }
        return view('merchant.merchant.edit',compact('merchant','parent_role','rate_company','charges','replenish','order_now','rate_remain'));
    }

    public function log(Merchant $merchant)
    {
        $logs = LoginLog::where(['role'=>'merchant','uid'=>$merchant->id])->paginate($this->per_page);
        return view('merchant.merchant.log',compact('merchant','logs'));
    }

    public function history(Merchant $merchant)
    {
        $histories = MerchantHistory::where(['role'=>'merchant','user_id'=>$merchant->id])->with('merchant')->paginate($this->per_page);
        return view('merchant.merchant.history',compact('merchant','histories'));
    }

    public function delete()
    {

    }

    public function merchants(Request $request)
    {
        $merchants = Merchant::where([['role_id',$request->get('role')],['status','<>',0]])->get();
        return ajax_return($merchants->count(), compact('merchants'));
    }

    public function merchant(Request $request)
    {
        $merchant = Merchant::where('id',$request->get('merchant'))->with('info')->firstOrFail();
        return ajax_return(1, compact('merchant'));
    }

    public function offline(Request $request)
    {
        $role = $request->get('role');
        $user = $request->get('user');
        if($role=='member'){
            $user = Member::find($user);
        }else{
            $user = Merchant::find($user);
        }
        $user->login_token = '';
        $user->save();
        return ajax_return(1);
    }
}

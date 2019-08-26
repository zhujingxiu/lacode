<?php
namespace App\Admin\Controllers;

use App\Libs\Game\Models\Game;
use App\Libs\Merchant\Models\Merchant as MerchantModel;
use App\Admin\Requests\FormMerchant;
use App\Models\SystemRole;

class MerchantController extends Controller
{
    /*
     * 用户列表
     */
    public function index($code)
    {
        $role = SystemRole::where(['code'=>strtolower($code),'role'=>'merchant'])->firstOrFail();
        $page_title = '商户管理 - '.$role->title;


        return view('admin.merchant.index', compact('page_title', 'role', 'code'));
    }

    public function listData(SystemRole $role)
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
        $total = $role->merchants()->where($where)->count();
        $merchants = $role->merchants()->where($where)->with(['info'])->paginate(20);
        foreach ($merchants as $merchant){
            $_company = $_shareholder = $_agent = $_proxy = 0;
            switch ($role->code){
                case 'company':
                    $_company = $merchant->name;
                    $result = $merchant->referralMerchantCountByRole();
                    $_shareholder = empty($result['agent']) ? 0 : count($result['agent']);
                    $_agent = empty($result['agent']) ? 0 : count($result['agent']);
                    $_proxy = empty($result['proxy']) ? 0 : count($result['proxy']);
                    break;
                case 'shareholder':
                    $_company = $merchant->parent->name;
                    $_shareholder = $merchant->name;
                    $result = $merchant->referralMerchantCountByRole();
                    $_agent = empty($result['agent']) ? 0 : count($result['agent']);
                    $_proxy = empty($result['proxy']) ? 0 : count($result['proxy']);
                    break;
                case 'agent':
                    $_company = $merchant->parent->parent->name;
                    $_shareholder = $merchant->parent->name;
                    $_agent = $merchant->name;
                    $_proxy = $merchant->children->count();
                    break;
                case 'proxy':
                    $_company = $merchant->parent->parent->parent->name;
                    $_shareholder = $merchant->parent->parent->name;
                    $_agent = $merchant->parent->name;
                    $_proxy = $merchant->name;
                    break;
            }

            $rows[] = [
                'mid' => $merchant->id,
                'nickname' => $merchant->nick_name,
                'company' => $_company,
                'shareholder' => $_shareholder,
                'agent' => $_agent,
                'proxy' => $_proxy,
                'rate' => $merchant->info->rate,
                'balance' => $merchant->info->balance,
                'online' => $merchant->online,
                'status' => $merchant->status,
                'joined' => $merchant->created_at->format('Y-m-d'),
                'rebate_link' => route('admin.merchant-rebates', $merchant)
            ];
        }
        return ['error_code'=>0,'rows'=>$rows,'total'=>$total];
    }

    public function create(SystemRole $role)
    {
        $parents = FALSE;
        if($role->code=='shareholder'){
            $parent_role = SystemRole::where('code','company')->first();
            $parents = MerchantModel::where(['role_id'=>$parent_role->id,'status'=>1])->get();
        }
        if($role->code=='agent'){
            $parent_role = SystemRole::where('code','shareholder')->first();
            $parents = MerchantModel::where(['role_id'=>$parent_role->id,'status'=>1])->get();
        }
        if($role->code=='proxy'){
            $parent_role = SystemRole::where('code','agent')->first();
            $parents = MerchantModel::where(['role_id'=>$parent_role->id,'status'=>1])->get();
        }
        return ajax_return(1, [
            'title' => '添加'.$role->title,
            'tpl' => response(view('admin.merchant.new', compact('parents', 'role')))->getContent()
        ]);
    }

    /*
     * 创建用户
     */
    public function store(FormMerchant $request)
    {
        $role = SystemRole::where('code', $request->input('code'))->firstOrFail();
        $merchant_class = sprintf('%s\Merchant%s', config('site.merchant_namespace'), ucwords($role->code));
        $merchant = \App::make($merchant_class,['code'=>$request->input('code')]);
        $ret = $merchant->addNew($request->except('_token'));
        return ajax_return($ret);
    }

    public function disabled()
    {

    }

    public function rebates(MerchantModel $merchant)
    {
        if (\Request::isMethod('post')) {
            $role = SystemRole::where('code', $merchant->role->code)->firstOrFail();
            $merchant_class = sprintf('%s\Merchant%s', config('site.merchant_namespace'), ucwords($role->code));
            $merchantRole = \App::make($merchant_class,['code'=>$merchant->role->code]);
            $input = \Request::input('rebate');
            if(!$input){
                return ajax_return(0,'退水设置更新失败');
            }
            $ret = $merchantRole->rebates($merchant->id,$input);
            return ajax_return($ret,'退水设置更新'.($ret ? '成功' : '失败'));
        }
        $page_title = '退水设置-'.$merchant->nick_name;
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
        $merchant->load(['rebates'=>function($query){
            $query->where('role','merchant');
        }]);
        $merchant_rebates = [];
        foreach($merchant->rebates as $rebate){
            $merchant_rebates[$rebate->option_id][$rebate->g_key] = $rebate->g_value;
        }
        return view('admin.merchant.rebate', compact('page_title','merchant','merchant_rebates','games'));
    }

    /**
     * @return array|void
     */
    public function games()
    {
        if (\Request::isMethod('post')) {
            $code = 'company';
            $merchant_class = sprintf('%s\Merchant%s', config('site.merchant_namespace'), ucwords($code));
            $merchantRole = \App::make($merchant_class,['code'=>$code]);
            $input = \Request::input('game');
            if(!$input){
                return ajax_return(0,'彩种授权更新失败');
            }
            $ret = $merchantRole->games($input);

            return ajax_return($ret,'彩种授权更新'.($ret ? '成功' : '失败'));
        }
        $mids = \Request::input('selected');
        if(!$mids){
            return ajax_return(0,'请选择一个商户');
        }
        $merchants = MerchantModel::with('games')->whereIn('id',$mids)->get();
        foreach ($merchants as $key => $merchant) {
            $merchants[$key]->games = $merchant->games->transform(function ($_game, $key) {
                if($_game->status)
                    return $_game->game_id;
            })->toArray();
        }
        $games = Game::where('status',1)->get();
        return ajax_return(1, [
            'title' => '彩种授权',
            'tpl' => response(view('admin.merchant.game', compact('games', 'merchants')))->getContent()
        ]);
    }
}
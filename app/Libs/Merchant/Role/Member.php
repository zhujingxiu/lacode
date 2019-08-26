<?php

namespace App\Libs\Merchant\Role;

use App\Libs\Merchant\Models\Merchant;
use \DB;
class Member
{
    protected $parent_code;
    protected $title;
    protected $merchant;
    protected $table_game_option = 'game_options';
    protected $table_game_rebates = 'game_rebates';
    protected $table_role = 'system_roles';
    protected $table_game = 'merchant_games';
    protected $table_merchant = 'merchants';
    protected $table_member = 'members';
    protected $table_info = 'member_infos';
    protected $table_relations = 'merchant_relations';
    protected $table_rebates = 'merchant_rebates';
    protected $table_history = 'merchant_history';
    protected $merchant_fk = 'merchant_id';
    protected $member_fk = 'member_id';
    protected $parent_merchant;
    protected $pk;
    protected $role_company = 'company';
    protected $role_shareholder = 'shareholder';
    protected $role_agent = 'agent';
    protected $role_proxy = 'proxy';
    protected $role_member = 'member';

    public function __construct($code)
    {
        $this->parent_code = $code;
    }

    /**
     * 上級商戶角色
     * @return bool
     */
    protected function merchant_role($role='')
    {
        $parent_code = $this->role_proxy;
        switch ($this->parent_code){
            case $this->role_shareholder:
                $parent_code = 'company';
                break;
            case $this->role_agent:
                $parent_code = 'shareholder';
                break;
            case $this->role_proxy:
                $parent_code = 'agent';
                break;
        }
        if($parent_code){
            $role = DB::table($this->table_role)->where('code',$parent_code)->first();
            if($role){
                return $role;
            }
        }
        return FALSE;
    }

    public function addNew($input)
    {

        if(!isset($input['merchant_id'])){
            return FALSE;
        }
        DB::beginTransaction();
        try{
            $this->merchant = DB::table($this->table_merchant)->where([['status','!=', 0],['id',$input['merchant_id']]])->first();
            $data = [
                'admin_id' => session(config('site.login_guard')) == 'admin' ? \Auth::guard('admin')->user()->id : 0,
                'merchant_id' => $input['merchant_id'],
                'uid' => str_replace('-','',\Uuid::generate()),
                'name' => $input['name'],
                'nick_name' => $input['nick_name'],
                'password' => bcrypt($input['password']),
                'status' => 1,
                'reset'=>1,
                'online'=>0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $this->pk = DB::table($this->table_member)->insertGetId($data);
            $money = $this->calculateCredit($input['credit']);
            DB::table($this->table_info)->insert([
                'member_id'=> $this->pk,
                'credit'=> $money,
                'balance'=> $money,
                'rate'=> (float)$input['rate'],
                'roulette' => empty($input['roulette']) ? 'a' : $input['roulette'],
            ]);
            //初始化会员关联关系
            $this->initialRelations();
            //初始化会员退水设置
            $this->initialRebates(empty($input['rebate']) ? 0 : $input['rebate']);
            DB::commit();
        }catch (\Exception $e){
            dd($e);
            DB::rollback();
            return FALSE;
        }
        return $this->pk;
    }

    protected function calculateCredit($credit)
    {
        return $credit;
    }
    /**
     * 初始化商户关联关系
     */
    protected function initialRelations()
    {
        $relations_batch = [];

        if($this->parent_code== $this->role_company){
            //分公司直属
            $relations_batch = [
                ['parent_role'=>$this->role_company,'merchant_id'=>$this->merchant->id,'child_role'=>$this->role_member,'user_id'=>$this->pk]
            ];
        }else if($this->parent_code == $this->role_shareholder){
            // 股东直属
            $relations_batch = [
                ['parent_role'=>$this->role_shareholder,'merchant_id'=>$this->merchant->id,'child_role'=>$this->role_member,'user_id'=>$this->pk],
                ['parent_role'=>$this->role_company,'merchant_id'=>$this->merchant->parent_id,'child_role'=>$this->role_member,'user_id'=>$this->pk]
            ];

        }else if($this->parent_code == $this->role_agent){
            // 总代理直属
            $tmp = [
                ['parent_role'=>$this->role_agent,'merchant_id'=>$this->merchant->id,'child_role'=>$this->role_member,'user_id'=>$this->pk],
                ['parent_role'=>$this->role_shareholder,'merchant_id'=>$this->merchant->parent_id,'child_role'=>$this->role_member,'user_id'=>$this->pk]
            ];
            $shareholder = DB::table($this->table_merchant)->find($this->merchant->parent_id);
            $tmp[] = ['parent_role'=>$this->role_company,'merchant_id'=>$shareholder->parent_id,'child_role'=>$this->role_member,'user_id'=>$this->pk];
            $relations_batch = $tmp;
        }else if($this->parent_code == $this->role_proxy){
            //普通会员
            $tmp = [
                ['parent_role'=>$this->role_proxy,'merchant_id'=>$this->merchant->id,'child_role'=>$this->role_member,'user_id'=>$this->pk],
                ['parent_role'=>$this->role_agent,'merchant_id'=>$this->merchant->parent_id,'child_role'=>$this->role_member,'user_id'=>$this->pk]
            ];
            $agent = DB::table($this->table_merchant)->find($this->merchant->parent_id);
            $tmp[] = ['parent_role'=>$this->role_shareholder,'merchant_id'=>$agent->parent_id,'child_role'=>$this->role_member,'user_id'=>$this->pk];
            $shareholder = DB::table($this->table_merchant)->find($agent->parent_id);
            $tmp[] = ['parent_role'=>$this->role_company,'merchant_id'=>$shareholder->parent_id,'child_role'=>$this->role_member,'user_id'=>$this->pk];
            $relations_batch = $tmp;
        }
        if($relations_batch){
            DB::table($this->table_relations)->where(['child_role'=>$this->role_member,'user_id'=>$this->pk])->delete();
            return DB::table($this->table_relations)->insert($relations_batch);
        }
        return FALSE;
    }
    /**
     * 初始化商戶退水
     * @return bool
     */
    protected function initialRebates($rebate_value)
    {
        //加载对应的商户退水
        $merchant_rebates = DB::table($this->table_rebates)->where(['role'=>'merchant','user_id'=>$this->merchant->id])->get();

        $member_rebates = [];
        foreach($merchant_rebates as $rebate){
            if(in_array($rebate->g_key,['a_limit','b_limit','c_limit'])){
                $member_rebates[$rebate->option_id][$rebate->g_key] = min(bcadd($rebate->g_value,(float)$rebate_value,2),100);
            }else{
                $member_rebates[$rebate->option_id][$rebate->g_key] = $rebate->g_value;
            }
        }
        $this->rebates($this->pk,$member_rebates);
    }

    public function rebates($member_id,$input)
    {

        DB::beginTransaction();
        try{
            $merchant_rebates_batch = [];
            foreach ($input as $option_id => $rebate){
                foreach ($rebate as $key=>$value){
                    $merchant_rebates_batch[] = [
                        'role'=>$this->role_member,
                        'user_id'=>$member_id,
                        'option_id'=>$option_id,
                        'g_key'=>$key,
                        'g_value'=>$value,
                    ];
                }
            }
            if($merchant_rebates_batch){
                DB::table($this->table_rebates)->where(['role'=>$this->role_member,'user_id'=>$member_id])->delete();
                DB::table($this->table_rebates)->insert($merchant_rebates_batch);
            }
            DB::commit();
        }catch (\Exception $e){
            dd($e);
            DB::rollback();
            return FALSE;
        }
        return TRUE;
    }

    public function recharge($member_id, $value)
    {
        DB::beginTransaction();
        try{

            $info = DB::table($this->table_info)->where(['member_id'=>$member_id])->first();
            if(!isset($info->balance)){
                return FALSE;
            }
            $balance = $info->balance;
            $new_value = $value+$balance;
            DB::table($this->table_info)->where(['member_id'=>$member_id])->update(['balance'=>$new_value]);
            DB::table($this->table_history)->insert([
                'role'=>$this->role_member,
                'user_id'=>$member_id,
                'action'=>'充值',
                'data'=>$balance,
                'request'=>$value,
                'note'=>'充值后余额为：'.$new_value,
                'ip'=> ip_addr(),
                'locate'=> ip_addr(),
                'created_at'=> date('Y-m-d H:i:s'),
                'merchant_id'=>session(config('site.login_guard')) == 'merchant' ? \Auth::guard('merchant')->user()->id : null,
            ]);
            DB::commit();
        }catch (\Exception $e){
            dd($e);
            DB::rollback();
            return FALSE;
        }
        return TRUE;
    }
}
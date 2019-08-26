<?php

namespace App\Libs\Merchant;

use \DB;
use function PHPSTORM_META\type;

class BaseMerchant implements MerchantSettleInterface
{
    protected $code;
    protected $title;
    protected $table_game_option = 'game_options';
    protected $table_game_rebates = 'game_rebates';
    protected $table_games = 'games';
    protected $table_role = 'system_roles';
    protected $table_merchant_games = 'merchant_games';
    protected $table_merchant = 'merchants';
    protected $table_info = 'merchant_infos';
    protected $table_relations = 'merchant_relations';
    protected $table_rebates = 'merchant_rebates';
    protected $merchant_fk = 'merchant_id';
    protected $parent_merchant;
    protected $role_company = 'company';
    protected $role_shareholder = 'shareholder';
    protected $role_agent = 'agent';
    protected $role_proxy = 'proxy';
    protected $pk;

    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * 上級商戶角色
     * @return bool
     */
    protected function parent_role()
    {
        $parent_code = FALSE;
        switch ($this->code){
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

    /**
     * 下級商戶角色
     * @return bool
     */
    protected function referral_role()
    {
        $referral_code = FALSE;
        switch ($this->code){
            case $this->role_company:
                $referral_code = 'shareholder';
                break;
            case $this->role_shareholder:
                $referral_code = 'agent';
                break;
            case $this->role_agent:
                $referral_code = 'proxy';
                break;
        }
        if($referral_code){
            $role = DB::table($this->table_role)->where('code',$referral_code)->first();
            if($role){
                return $role;
            }
        }
        return FALSE;
    }

    /**
     * 新增商戶
     * @param $info
     * @return bool
     */
    public function addNew($info)
    {

        DB::beginTransaction();
        $role = DB::table($this->table_role)->where(['role'=>'merchant','code'=>$this->code])->first();
        if(!$role->id){
            return FALSE;
        }
        try{
            if(!isset($info['credit'])){
                $info['credit'] =0 ;
            }
            $data = [
                'admin_id' => session(config('site.login_guard')) == 'admin' ? \Auth::guard('admin')->user()->id : 0,
                'role_id' => $role->id,
                'code' => empty($info['code']) ? '' : trim($info['code']),
                'name' => $info['name'],
                'nick_name' => $info['nick_name'],
                'password' => bcrypt($info['password']),
                'status' => empty($info['status']) ? 1: (int)($info['status']),
                'reset'=>1,
                'online'=>0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            if(!empty($info['parent_id'])){
                $this->parent_merchant = DB::table($this->table_merchant)->find($info['parent_id']);
                if(!$this->parent_merchant->id){
                    return FALSE;
                }
                $this->parent_merchant->info = DB::table($this->table_info)->where($this->merchant_fk,$this->parent_merchant->id)->first();
                $data['parent_id'] = $info['parent_id'];
            }
            //添加商戶
            $this->pk = DB::table($this->table_merchant)->insertGetId($data);
            //添加商戶信息
            $money = $this->calculateCredit($info['credit']);
            DB::table($this->table_info)->insert([
                'merchant_id'=> $this->pk,
                'credit'=> $money,
                'balance'=> $money,
                'rate'=> $this->calculateRate($info),
                'rate_limit'=> $this->calculateRateLimit($info),
                'rate_company'=> $this->getRateCompany(isset($info['rate_company'])? $info['rate_company']: 0),
                'charges'=> $this->getCharges(isset($info['charges'])?$info['charges']:0),
                'replenish' => empty($info['replenish']) ? 0 :(int)$info['replenish'],
                'order_now' => empty($info['order_now']) ? 0 : (int)$info['order_now'],
            ]);
            //初始化商戶关联关系
            $this->initialRelations();
            //初始化商戶退水
            $this->initialRebates();
            //初始化分公司商戶彩種狀態
            $this->initialGames();
            //更新上级商户信用余额
            $parent_decrement_offset = $this->parentDecrementBalance($info['credit']);
            if(is_numeric($parent_decrement_offset) && !empty($info['parent_id'])) {
                DB::table($this->table_info)->where('merchant_id', $info['parent_id'])->decrement('balance', $parent_decrement_offset);
            }
            DB::commit();
        }catch (\Exception $e){
            dd($e);
            DB::rollback();
            return FALSE;
        }

        return $this->pk;
    }

    protected function getRateCompany($rate_company)
    {
        return $this->parent_merchant->info->rate_company;
    }

    protected function getCharges($charges)
    {
        return 0;
    }

    protected function calculateRate($data){
        return isset($data['rate']) ?  (float)$data['rate'] : 0;
    }
    /**
     * 計算上级佔成限制
     * @param $rate
     * @return int
     */
    protected function calculateRateLimit($data)
    {
        return 0;
    }

    /**
     * 計算信用額
     * @param $credit
     * @return mixed
     */
    protected function calculateCredit($credit)
    {
        return $credit;
    }

    /**
     * 初始化彩種的關聯關係
     * @return bool
     */
    protected function initialGames()
    {
        return TRUE;
    }

    /**
     * 計算更新上級商戶餘額的偏移量
     * @param $value
     * @return mixed
     */
    protected function parentDecrementBalance($value)
    {
        return $value;
    }

    /**
     * 獲取上級退水
     * @return array
     */
    protected function parentRebates()
    {
        $rebates = DB::table($this->table_rebates)->where([['role','merchant'],['user_id',$this->parent_merchant->id]])->select(['option_id','g_key','g_value'])->get()->transform(function ($item, $key) {
            $tmp = [];
            foreach ($item as $_key=>$_value){
                $tmp[$_key] = $_value;
            }
            $tmp['user_id'] = $this->pk;
            $tmp['role'] = 'merchant';
            return $tmp;
        });

        return $rebates->toArray();
    }

    /**
     * 初始化商戶退水
     * @return bool
     */
    protected function initialRebates()
    {
        $default_rebates_batch = $this->parentRebates();
        if($default_rebates_batch){
            DB::table($this->table_rebates)->where(['role'=>'merchant','user_id'=>$this->pk])->delete();
            DB::table($this->table_rebates)->insert($default_rebates_batch);
            return TRUE;
        }
        return FALSE;
    }
    /**
     * 獲取上級关联关系
     * @return array
     */
    protected function parentRelations()
    {
        return [];
    }
    /**
     * 初始化商户关联关系
     */
    protected function initialRelations()
    {
        $relations_batch = $this->parentRelations();
        if($relations_batch){
            DB::table($this->table_relations)->where(['child_role'=>$this->code,'user_id'=>$this->pk])->delete();
            return DB::table($this->table_relations)->insert($relations_batch);
        }
        return FALSE;
    }
    /**
     * 更新商戶退水
     * @param $merchant_id
     * @param $input
     * @return bool
     */
    public function rebates($merchant_id,$input)
    {
        if(!is_array($input)){
            return FALSE;
        }
        DB::beginTransaction();
        try{
            $trait_special = FALSE;
            $trait_double = FALSE;
            $trait_serial = FALSE;
            $trait_other = FALSE;
            $game_rebates_batch = [];
            if(isset($input['special'])){
                $trait_special = $input['special'];
                foreach ($trait_special as $game_id=>$rebate){
                    foreach ($rebate as $key=>$value){
                        $game_rebates_batch[$game_id][] = [
                            'trait'=> 'special',
                            'game_id'=>$game_id,
                            'g_key'=>$key,
                            'g_value'=>$value,
                        ];
                    }
                }
                unset($input['special']);
            }
            if(isset($input['double'])){
                $trait_double = $input['double'];
                foreach ($trait_double as $game_id=>$rebate){
                    foreach ($rebate as $key=>$value){
                        $game_rebates_batch[$game_id][] = [
                            'trait'=> 'double',
                            'game_id'=>$game_id,
                            'g_key'=>$key,
                            'g_value'=>$value,
                        ];
                    }
                }
                unset($input['double']);
            }
            if(isset($input['serial'])){
                $trait_serial = $input['serial'];
                foreach ($trait_serial as $game_id=>$rebate){
                    foreach ($rebate as $key=>$value){
                        $game_rebates_batch[$game_id][] = [
                            'trait'=> 'serial',
                            'game_id'=>$game_id,
                            'g_key'=>$key,
                            'g_value'=>$value,
                        ];
                    }
                }
                unset($input['serial']);
            }
            if(isset($input['other'])){
                $trait_other = $input['other'];
                foreach ($trait_other as $game_id=>$rebate){
                    foreach ($rebate as $key=>$value){
                        $game_rebates_batch[$game_id][] = [
                            'trait'=> 'other',
                            'game_id'=>$game_id,
                            'g_key'=>$key,
                            'g_value'=>$value,
                        ];
                    }
                }
                unset($input['other']);
            }
            $merchant_rebates_batch = [];
            foreach ($input as $option_id => $rebate){

                $valid_sum = array_sum($rebate);
                if(!is_numeric($valid_sum) || $valid_sum <= 0){
                    $option = DB::table($this->table_game_option)->find($option_id);
                    if(!$option || empty($option->trait)|| empty($option->game_id)){
                        continue;
                    }
                }
                foreach ($rebate as $key=>$value){
                    if(!is_numeric($value)){
                        $trait = $option->trait;
                        $game_id = $option->game_id;
                        if(isset(${'trait_'.$trait}[$game_id][$key])){
                            $value = ${'trait_'.$trait}[$game_id][$key];
                        }else{
                            $value = 0;
                        }
                    }
                    $merchant_rebates_batch[] = [
                        'role'=>'merchant',
                        'user_id'=>$merchant_id,
                        'option_id'=>$option_id,
                        'g_key'=>$key,
                        'g_value'=>$value,
                    ];
                }
            }
            if($merchant_rebates_batch){
                DB::table($this->table_rebates)->where(['role'=>'merchant','user_id'=>$merchant_id])->delete();
                DB::table($this->table_rebates)->insert($merchant_rebates_batch);
            }
            if($game_rebates_batch){
                //更新默认退水设置
//                foreach ($game_rebates_batch as $game_id => $update){
//                    DB::table($this->table_game_rebates)->where('game_id', $game_id)->delete();
//                    DB::table($this->table_game_rebates)->insert($update);
//                }

            }
            DB::commit();
        }catch(\Exception $e){

            dd($e);
            DB::rollback();
            return FALSE;
        }

        return TRUE;
    }

    public function games( $input)
    {
        if(!is_array($input)){
            return FALSE;
        }

        DB::beginTransaction();
        try{
            $batch = [];
            foreach ($input as $merchat_id => $item){
                foreach ($item as $game_id=>$param){
                    if(!empty($param['status'])){
                        $batch[$merchat_id][] = [
                            'merchant_id' => $merchat_id,
                            'game_id' => $game_id,
                            'status'=>1
                        ];
                    }
                }
            }
            if($batch){
                foreach ($batch as $merchant_id => $insert){
                    DB::table($this->table_merchant_games)->where('merchant_id', $merchant_id)->delete();
                    DB::table($this->table_merchant_games)->insert($insert);
                }
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            return FALSE;
        }
        return TRUE;

    }

    public function settle()
    {
        // TODO: Implement settle() method.
    }

}
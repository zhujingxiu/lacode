<?php

namespace App\Libs\Merchant\Role;
use \DB;
use App\Libs\Merchant\BaseMerchant;
class MerchantProxy extends BaseMerchant
{

    protected function calculateRateLimit($data)
    {

        return empty($data['rate']) ? 0 : (float) $data['rate'];
    }

    protected function calculateRate($data)
    {
        if(!empty($data['rate_remain'])){
            return bcsub($this->parent_merchant->info->rate , $data['rate'],2);
        }
        return empty($data['rate_self']) ? 0 : (float)$data['rate_self'];
    }

    protected function parentRelations()
    {
        $agent = $this->parent_merchant;
        $shareholder = DB::table($this->table_merchant)->where('id',$agent->parent_id)->first();
        $company = DB::table($this->table_merchant)->where('id',$shareholder->parent_id)->first();
        return [
            ['parent_role'=>$this->role_agent,'merchant_id'=>$agent->id,'child_role'=>$this->code,'user_id'=>$this->pk],
            ['parent_role'=>$this->role_shareholder,'merchant_id'=>$shareholder->id,'child_role'=>$this->code,'user_id'=>$this->pk],
            ['parent_role'=>$this->role_company,'merchant_id'=>$company->id,'child_role'=>$this->code,'user_id'=>$this->pk],
        ];
    }
}
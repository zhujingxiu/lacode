<?php

namespace App\Libs\Merchant\Role;

use App\Libs\Merchant\BaseMerchant;
class MerchantShareholder extends BaseMerchant
{
    protected function calculateRateLimit($data)
    {
        return bcsub($this->parent_merchant->info->rate , $data['rate'],2);
    }
    protected function parentRelations()
    {
        return [
            ['parent_role'=>$this->role_company,'merchant_id'=>$this->parent_merchant->id,'child_role'=>$this->code,'user_id'=>$this->pk],
        ];
    }


}
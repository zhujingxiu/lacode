<?php

namespace App\Libs\Merchant\Role;
use \DB;
use App\Libs\Merchant\BaseMerchant;
class MerchantAgent extends BaseMerchant
{
    // 占余成数下线任占
    /**
     *
     * if ($_POST['zy'] == 1) {
    $s_Size = (int)$_POST['s_size_ky']; //上級占成
    $s_next_ky = $g_nid[0]['g_distribution'] - $s_Size; //下級占成
    } else {
    $s_Size = (int)$_POST['s_size_ky']; //上級占成
    $s_next_ky = $_POST['s_next_KY']; //下級占成
    }
     * if ($s_Size + $s_next_ky > $g_nid[0]['g_distribution']) exit(back('上級最高占成率：' . $g_nid[0]['g_distribution'] . '%'));
     * @param $data
     * @return int|string
     */
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
        $shareholder = $this->parent_merchant;
        $company = DB::table($this->table_merchant)->where('id',$shareholder->parent_id)->first();
        return [
            ['parent_role'=>$this->role_shareholder,'merchant_id'=>$shareholder->id,'child_role'=>$this->code,'user_id'=>$this->pk],
            ['parent_role'=>$this->role_company,'merchant_id'=>$company->id,'child_role'=>$this->code,'user_id'=>$this->pk],
        ];
    }
}
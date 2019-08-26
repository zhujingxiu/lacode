<?php

namespace App\Libs\Merchant\Role;
use \DB;
use App\Libs\Merchant\BaseMerchant;
class MerchantCompany extends BaseMerchant
{
    /**
     * 佔成限制
     * @param $rate
     * @return int
     */
    protected function calculateRateLimit($data){
        return empty($data['rate']) ? 0 : $data['rate'];
    }

    /**
     * 更新上級可用額度
     * 分公司不用更新
     * @param $value
     * @return bool
     */
    protected function parentDecrementBalance($value)
    {
        return FALSE;
    }

    /**
     * 上級退水設置
     * 分公司採用默認賠率
     * @return array
     */
    protected function parentRebates()
    {
        $data = [];
        $game_rebates = DB::table($this->table_game_rebates)->get()->groupBy('game_id');
        foreach ($game_rebates as $game_id => $rebates){
            $default = [];
            foreach ($rebates as $rebate){
                $default[$rebate->trait][$rebate->g_key]=$rebate->g_value;
            }
            $data[$game_id] = DB::table($this->table_game_option)->where('game_id',$game_id)->get()->groupBy('trait')->transform(function ($item, $key) use ($default) {
                $tmp = [];
                foreach ($item as $option){
                    $default_trait_rebates = isset($default[$option->trait]) ? $default[$option->trait] : [];
                    foreach ($default_trait_rebates as  $g_key => $g_value){
                        $tmp[] = [
                            'option_id' => $option->id,
                            'g_key' => $g_key,
                            'g_value' => $g_value,
                            'role'=>'merchant',
                            'user_id'=>$this->pk
                        ];

                    }
                }
                return $tmp;
            })->flatten(1);
        }
        return collect($data)->flatten(1)->toArray();
    }

    /*
     * 分公司更新merchant_games
     * 其他角色不用更新
     */
    protected function initialGames()
    {
        $game_batch = [];
        $games = DB::table($this->table_games)->where('status','1')->get();
        foreach ($games as $game){
            $game_batch[] = [
                'merchant_id' => $this->pk,
                'game_id' => $game->id,
                'status' => 1
            ];
        }
        if($game_batch){
            DB::table($this->table_merchant_games)->where('merchant_id',$this->pk)->delete();
            return DB::table($this->table_merchant_games)->insert($game_batch);
        }
        return FALSE;
    }

    protected function getRateCompany($rate_company)
    {
        return boolval($rate_company);
    }

    protected function getCharges($charges)
    {
        return $charges;
    }
}
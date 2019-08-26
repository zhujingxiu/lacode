<?php
namespace App\Libs\Merchant\Models;

use App\Libs\Game\Models\GameOption;
use App\Models\Model;
class MerchantRebate extends Model
{
    //
    public $timestamps = FALSE;

    public function option(){
        return $this->belongsTo(GameOption::class);
    }
}

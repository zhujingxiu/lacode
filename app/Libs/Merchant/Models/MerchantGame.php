<?php
namespace App\Libs\Merchant\Models;

use App\Libs\Game\Models\Game;
use App\Models\Model;
class MerchantGame extends Model
{
    //
    public $timestamps = FALSE;

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}

<?php

namespace App\Libs\Game\Models;

use App\Models\Model ;
class GameOdds extends Model
{
    //
    protected $table = 'game_odds';
    public $timestamps = FALSE;

    public function bet()
    {
        return $this->belongsTo(GameBet::class);
    }
}

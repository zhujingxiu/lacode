<?php

namespace App\Libs\Game\Models;

use App\Models\Model;

class GameScheduleIssue extends Model
{
    //
    public $timestamps = FALSE;

    public function game()
    {
        return $this->belongsTo(Game::class);
    }


}

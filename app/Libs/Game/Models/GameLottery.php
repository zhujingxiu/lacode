<?php

namespace App\Libs\Game\Models;

use App\Models\Model ;
class GameLottery extends Model
{
    public $timestamps = FALSE;
    public function lotteryTime()
    {
        return date('m-d',strtotime($this->open_time)).
            ' '.week_day(date('Y-m-d',strtotime($this->open_time))).
            ' '.date('H:i:s',strtotime($this->open_time));
    }



}

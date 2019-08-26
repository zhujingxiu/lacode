<?php

namespace App\Libs\Game\Models;

use App\Models\Model ;
class GameBet extends Model
{
    //
    public $timestamps = FALSE;
    protected $fillable = ['game_id','title','code','sort','status', 'style'];


}

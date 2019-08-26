<?php

namespace App\Libs\Game\Models;

use App\Models\Model ;
class GameRebate extends Model
{
    //
    public $timestamps = FALSE;
    protected $fillable = ['game_id','trait','g_key','g_value'];

}

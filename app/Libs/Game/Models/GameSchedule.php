<?php

namespace App\Libs\Game\Models;

use App\Models\Model ;
class GameSchedule extends Model
{
    //
    public $timestamps = FALSE;
    protected $table = 'game_schedules';
    protected $fillable = ['game_id','start_time','total','interval','ahead','sort','status'];
    public function game()
    {
        return $this->belongsTo(Game::class,'game_id');
    }

}

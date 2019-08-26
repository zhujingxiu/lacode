<?php

namespace App\Libs\Game\Models;

use App\Models\Model ;
class GameGroup extends Model
{
    //
    public $timestamps = FALSE;
    protected $fillable = ['game_id','title','code','sort','status'];

    public function oddsOptions()
    {
        return $this->hasMany(GameGroupOption::class,'group_id');
    }
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

}

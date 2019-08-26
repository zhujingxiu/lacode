<?php

namespace App\Libs\Game\Models;

use App\Models\Model ;
use App\Libs\Game\Models\GameGroup;
use App\Libs\Game\Models\GameOption;
class GameGroupOption extends Model
{
    //
    protected $table = 'game_group_option';
    public $timestamps = FALSE;


    public function option()
    {
        return $this->belongsTo(GameOption::class,'option_id');
    }

    public function group()
    {
        return $this->belongsTo(GameGroup::class,'group_id');
    }


}

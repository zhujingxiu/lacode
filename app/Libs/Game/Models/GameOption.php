<?php

namespace App\Libs\Game\Models;

use App\Models\Model ;
class GameOption extends Model
{
    //
    public $timestamps = FALSE;
    protected $fillable = ['game_id','title','code','sort'];

    public function oddsGroups()
    {
        return $this->belongsToMany(GameGroupOption::class, 'game_group_option', 'option_id','group_id')->withPivot(['option_id','group_id']);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public static function getTraits()
    {
        return [
            'special' => '特碼類',
            'double' => '兩面類',
            'serial' => '連碼類',
            'other' => '其他類',
        ];
    }
}

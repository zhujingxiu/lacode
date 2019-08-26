<?php

namespace App\Models;

use App\Libs\Game\Models\Game;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function infos()
    {
        return $this->hasMany(OrderInfo::class);
    }

    public function logs()
    {
        return $this->hasMany(OrderLog::class);
    }
}

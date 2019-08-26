<?php

namespace App\Libs\Game\Models;

use App\Models\Model ;
class Game extends Model
{
    //
    protected $fillable = ['title','code','total','status','sort','table_lottery'];

    public function schedules()
    {
        return $this->hasMany(GameSchedule::class)->orderBy('sort')->orderBy('id');
    }

    public function bets()
    {
        return $this->hasMany(GameBet::class)->orderBy('sort')->orderBy('id');
    }

    public function options()
    {
        return $this->hasMany(GameOption::class)->orderBy('sort')->orderBy('id');
    }

    public function groups()
    {
        return $this->hasMany(GameGroup::class)->orderBy('sort')->orderBy('id');
    }

    public function schedule_issues()
    {
        return $this->hasMany(GameScheduleIssue::class)->orderBy('issue')->orderBy('id');
    }

    public function odds_options()
    {
        return $this->hasManyThrough(GameGroupOption::class, GameGroup::class, 'game_id','group_id','id','id');
    }

    public function rebates()
    {
        return $this->hasMany(GameRebate::class);
    }

    public function lotteries()
    {
        return $this->hasMany(GameLottery::class)->orderBy('issue','desc');
    }
}

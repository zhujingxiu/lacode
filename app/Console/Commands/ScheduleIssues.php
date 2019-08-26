<?php

namespace App\Console\Commands;

use App\Libs\Game\Models\Game;
use Illuminate\Console\Command;
use \DB;
use \Log;
class ScheduleIssues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lottery:issues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    protected $game_codes = ['GameCqssc','GamePk10','GameXyft','GameJssc','GameJsssc'];
    public function handle()
    {
        DB::enableQueryLog();
        DB::beginTransaction();
        try {
            foreach ($this->game_codes as $game_code) {
                $this->scheduleIssues($game_code);
            }

            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            Log::info('['.$this->game_code."]自动加载盘口出错->".$e);

            return FALSE;
        }
//        $log = DB::getQueryLog();
//        $sql = end($log);
//        dd($sql);
        return TRUE;
    }

    private function scheduleIssues($game_code)
    {
        $this->line('预备加载盘口: ');
        $game = Game::where('code',$game_code)->firstOrFail();
        $this->line('彩种: '.$game->title);
        $schedules = DB::table('game_schedules')->where(['game_id'=>$game->id,'status'=>1])->orderBy('sort')->get();
        $begin_time = $end_time = FALSE;
        foreach ($schedules as $schedule){
            $start_time = strtotime(date('Y-m-d').' '.$schedule->start_time);
            if($begin_time==FALSE){
                $begin_time = $start_time;
            }
            $end_time = $start_time + $schedule->total*$schedule->interval;
        }
        $begin_hi = intval(date('Gi',$begin_time));
        $end_hi = intval(date('Gi',$end_time));
        $this->line('盘口起始时间: '.date('Y-m-d H:i:s',$begin_time).'-'.$begin_hi);
        $this->line('盘口结束时间: '.date('Y-m-d H:i:s',$end_time).'-'.$end_hi);
        $this->line('当前时间: '.date('Y-m-d H:i:s'));
        //在开盘前加载今天的开盘信息
        $load_schedules = FALSE;
        //隔天结束
        if($begin_hi > $end_hi){
            $end_time -= 24*3600;
        }else{
            //当日内结束 是否大于当日的结束时间小于第二天的开始时间
            $begin_time += 24*3600;
        }
        $had_record = DB::table('game_schedule_issues')->where([['game_id',$game->id],['status',0],['start_time','>',date('Y-m-d H:i:s')]])->first();

        if(time()>$end_time && time() < $begin_time){
            $load_schedules = TRUE;
        }else if(empty($had_record->issue)){
            $load_schedules = TRUE;
        }
        if($load_schedules){
            $this->line('符合加载条件，正在加载盘口: ');
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($game->code));
            $lottery = \App::make($game_class, ['game' => $game]);
            $ret = $lottery->resetSchedules($game->schedules->toArray());

            $this->line('盘口加载完成: '.$ret);
        }

        return TRUE;
    }
}

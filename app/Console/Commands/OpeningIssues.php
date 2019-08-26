<?php

namespace App\Console\Commands;

use App\Libs\Game\Models\Game;
use Illuminate\Console\Command;
use \DB;
use \Log;
use Illuminate\Support\Facades\Redis;
class OpeningIssues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opening:issues';

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
    private  $issue_table = 'game_schedule_issues';
    public function handle()
    {
        for ($i=1;$i<=10;$i++) {
            DB::enableQueryLog();
            DB::beginTransaction();
            try {
                foreach ($this->game_codes as $game_code) {
                    $this->openingIssues($game_code);
                }

                DB::commit();
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                Log::info("[自动更新盘口出错->" . $e);

                return FALSE;
            }
            sleep(6);
        }
//        $log = DB::getQueryLog();
//        $sql = end($log);
//        dd($sql);
        return TRUE;
    }

    private function openingIssues($game_code)
    {
        $this->line('预备更新盘口: ');
        $game = Game::where('code',$game_code)->firstOrFail();
        $this->line('彩种: '.$game->title);
        $now_date = date('Y-m-d H:i:s');
        //当前时间大于封盘时间的设置为过期
        $affected =DB::table($this->issue_table)
            ->where([['game_id', $game->id], ['end_time', '<=', $now_date]])
            ->update(['status' => -1]);
        //2.当前时间大于开盘时间的最近一期待开奖的状态设置为1
        $affected = DB::table($this->issue_table)
            ->where([['game_id', $game->id], ['start_time', '<=', $now_date],['end_time', '>', $now_date]])
            ->orderBy('start_time','desc')
            ->take(1)
            ->update(['status' => 1]);
        if($affected) {
            $issue_key = sprintf(config('site.opening_issue_key'), $game->id);
            $scheduleIssue = DB::table($this->issue_table)
                ->select(['issue', 'open_time', 'end_time', 'start_time'])
                ->where(['game_id' => $game->id, 'status' => 1])
                ->orderBy('issue', 'asc')
                ->first();
            Redis::set($issue_key, json_encode([
                'issue' => $scheduleIssue->issue,
                'open_time' => $scheduleIssue->open_time,
                'start_time' => $scheduleIssue->start_time,
                'end_time' => $scheduleIssue->end_time,
            ]));
        }
        return TRUE;
    }
}

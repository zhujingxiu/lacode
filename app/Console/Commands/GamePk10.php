<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \DB;
use \Log;
use App\Libs\Game\Models\Game;
class GamePk10 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lottery:pk10';

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
    protected $game_code = 'GamePk10';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('预备采集开奖结果: ');
        $game = Game::where('code',$this->game_code)->firstOrFail();
        $this->line('彩种: '.$game->title);
        $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($this->game_code));
        $lottery = \App::make($game_class, ['game' => $game]);
        $ret = $lottery->lotteryOpen();

        if(!empty($ret['error_code'])){
            $this->line($ret['msg']);
        }else{
            if(!empty($ret['url'])){
                $this->line('开奖采集地址：'.$ret['url']);
            }
            if(is_array($ret['numbers'])) {
                $this->line('采集结果入库: ' . implode(",", $ret['numbers']));
            }else{
                var_dump($ret);
            }
        }
    }
    private function lottery()
    {
        //开启查询记录
//        DB::enableQueryLog();
        $this->line('预备采集开奖结果: ');
        DB::beginTransaction();

        try {
            $game = Game::where('code',$this->game_code)->firstOrFail();
            //1.修改开奖时间早于当前时间的期数状态为-1， 已过期
            $now_date = date('Y-m-d H:i:s');
            DB::table('game_schedule_issues')->where([['game_id',$game->id],['open_time','<=',$now_date]])->update(['status'=>-1]);
            //2.最近一期待开奖的状态设置为1
            DB::table('game_schedule_issues')->where([['game_id',$game->id],['open_time','>',$now_date]])->orderBy('open_time')->take(1)->update(['status'=>1]);
            $this->line('彩种: '.$game->title);

            //3.采集数据
            $_api_url = 'https://www.ss1300.com:8090/api/newest?code=pk10&t=' . time();
            $this->line('API地址: '.$_api_url);
            $result = http_curl($_api_url);

            if (!empty($result['code']) || !isset($result['data']) || !isset($result['data']['newest']) || !isset($result['data']['newest']['array'])) {
                $this->line('开奖数据采集异常');
                return FALSE;
            }
            $numbers = $result['data']['newest']['array'];
            if (count($numbers) != 10) {
                $this->line('开奖数据采集异常');
                return FALSE;
            }
            $this->line('采集结果: '.implode(",",$numbers));

            $tmp = [
                'game_id' => $game->id,
                'open_time' => $result['data']['newest']['time'],
                'issue' => $result['data']['newest']['issue'],
                'sum' => $result['data']['newest']['sum'],
                'summery' => implode("|",$result['data']['summery']),
                'no_1' => $numbers[0],
                'no_2' => $numbers[1],
                'no_3' => $numbers[2],
                'no_4' => $numbers[3],
                'no_5' => $numbers[4],
                'no_6' => $numbers[5],
                'no_7' => $numbers[6],
                'no_8' => $numbers[7],
                'no_9' => $numbers[8],
                'no_10' => $numbers[9],
            ];
            // 4.更新采集开奖时间为预定时间
            $issueObj = DB::table('game_schedule_issues')->where(['game_id'=>$game->id,'issue'=>$tmp['issue']])->first();
            if(!empty($issueObj->issue)){
                $tmp['open_time'] = $issueObj->open_time;
            }
            // 5.是否已存在开奖结果
            $exists = DB::table($game->table_lottery)->where(['game_id'=>$game->id,'issue'=>$tmp['issue']])->first();
            if(isset($exists->sum) && $exists->sum > 0){
                $this->line(sprintf('已存在开奖结果: %s期【%s】{ %s }',$exists->issue,$game->title,$exists->summery));
                return FALSE;
            }
            // 6.采集入库
            $this->line(sprintf('采集入库: %s期【%s】{ %s }', $tmp['issue'], $game->title, implode(",",$numbers)));
            DB::table($game->table_lottery)->insert($tmp);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::info('['.$this->game_code."]自动采集开奖出错->".$e);
            return FALSE;
        }
        return TRUE;
    }

}

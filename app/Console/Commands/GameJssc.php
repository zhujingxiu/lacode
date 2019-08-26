<?php

namespace App\Console\Commands;

use App\Libs\Game\Models\Game;
use Illuminate\Console\Command;
use \DB;
use \Log;
class GameJssc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lottery:jssc';

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
    protected $game_code = 'GameJssc';
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
        for ($i=1;$i<=4;$i++) {
            $this->line('预备采集开奖结果: ');
            $game = Game::where('code', $this->game_code)->firstOrFail();
            $this->line('彩种: ' . $game->title);
            $game_class = sprintf('%s\%s', config('site.game_namespace'), ucwords($this->game_code));
            $lottery = \App::make($game_class, ['game' => $game]);
            $ret = $lottery->lotteryOpen();

            if (!empty($ret['error_code'])) {
                $this->line($ret['msg']);
            } else {
                if (!empty($ret['url'])) {
                    $this->line('开奖采集地址：' . $ret['url']);
                }
                if (is_array($ret['numbers'])) {
                    $this->line('采集结果入库: ' . implode(",", $ret['numbers']));
                } else {
                    var_dump($ret);
                }
            }
            sleep(15);
        }
    }

}

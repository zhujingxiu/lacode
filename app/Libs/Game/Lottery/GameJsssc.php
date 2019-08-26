<?php

namespace App\Libs\Game\Lottery;
use App\Libs\Game\BaseGame;
use App\Libs\Game\Traits\RuleSsc5;
use \DB;
class GameJsssc extends BaseGame
{
    use RuleSsc5;
    protected $default_issue_suffix_length = 4;

    protected $default_bets = [
        ['title'=>'0','code'=>'bet_0','sort'=>1,'style'=>'ball-num'],
        ['title'=>'1','code'=>'bet_1','sort'=>1,'style'=>'ball-num'],
        ['title'=>'2','code'=>'bet_2','sort'=>1,'style'=>'ball-num'],
        ['title'=>'3','code'=>'bet_3','sort'=>1,'style'=>'ball-num'],
        ['title'=>'4','code'=>'bet_4','sort'=>1,'style'=>'ball-num'],
        ['title'=>'5','code'=>'bet_5','sort'=>1,'style'=>'ball-num'],
        ['title'=>'6','code'=>'bet_6','sort'=>1,'style'=>'ball-num'],
        ['title'=>'7','code'=>'bet_7','sort'=>1,'style'=>'ball-num'],
        ['title'=>'8','code'=>'bet_8','sort'=>1,'style'=>'ball-num'],
        ['title'=>'9','code'=>'bet_9','sort'=>1,'style'=>'ball-num'],
        ['title'=>'大','code'=>'bet_da','sort'=>1,'style'=>''],
        ['title'=>'小','code'=>'bet_x','sort'=>1,'style'=>''],
        ['title'=>'單','code'=>'bet_d','sort'=>1,'style'=>''],
        ['title'=>'雙','code'=>'bet_s','sort'=>1,'style'=>''],
        ['title'=>'總和大','code'=>'bet_zhd','sort'=>1,'style'=>''],
        ['title'=>'總和小','code'=>'bet_zhx','sort'=>1,'style'=>''],
        ['title'=>'總和單','code'=>'bet_zhda','sort'=>1,'style'=>''],
        ['title'=>'總和雙','code'=>'bet_zhs','sort'=>1,'style'=>''],
        ['title'=>'龍','code'=>'bet_long','sort'=>1,'style'=>''],
        ['title'=>'虎','code'=>'bet_hu','sort'=>1,'style'=>''],
        ['title'=>'和','code'=>'bet_he','sort'=>1,'style'=>''],
        ['title'=>'豹子','code'=>'bet_bz','sort'=>1,'style'=>''],
        ['title'=>'順子','code'=>'bet_sz','sort'=>1,'style'=>''],
        ['title'=>'對子','code'=>'bet_dz','sort'=>1,'style'=>''],
        ['title'=>'半順','code'=>'bet_bs','sort'=>1,'style'=>''],
        ['title'=>'雜六','code'=>'bet_zl','sort'=>1,'style'=>''],
    ];

    protected $default_options = [
        ['trait'=>'special','title'=>'第一球','code'=>'opt_1','sort'=>1,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第二球','code'=>'opt_2','sort'=>2,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第三球','code'=>'opt_3','sort'=>3,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第四球','code'=>'opt_4','sort'=>4,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第五球','code'=>'opt_5','sort'=>5,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'double','title'=>'1-5大小','code'=>'opt_dx','sort'=>6,'diff_b'=>'0.04','diff_c'=>'0.06'],
        ['trait'=>'double','title'=>'1-5單雙','code'=>'opt_ds','sort'=>7,'diff_b'=>'0.04','diff_c'=>'0.06'],
        ['trait'=>'double','title'=>'總和大小','code'=>'opt_dx2','sort'=>8,'diff_b'=>'0.04','diff_c'=>'0.06'],
        ['trait'=>'double','title'=>'總和單雙','code'=>'opt_ds2','sort'=>9,'diff_b'=>'0.04','diff_c'=>'0.06'],
        ['trait'=>'double','title'=>'龍虎和','code'=>'opt_lh','sort'=>10,'diff_b'=>'0.04','diff_c'=>'0.06'],
        ['trait'=>'serial','title'=>'前三','code'=>'opt_q3','sort'=>11,'diff_b'=>'0.1','diff_c'=>'0.2'],
        ['trait'=>'serial','title'=>'中三','code'=>'opt_z3','sort'=>12,'diff_b'=>'0.1','diff_c'=>'0.2'],
        ['trait'=>'serial','title'=>'后三','code'=>'opt_h3','sort'=>13,'diff_b'=>'0.1','diff_c'=>'0.2'],
    ];

    protected $default_groups = [
        ['title'=>'兩面盤','code'=>'grp_sm','sort'=>1],
        ['title'=>'單球1-5','code'=>'grp_dq','sort'=>2],
        ['title'=>'第一球','code'=>'grp_1','sort'=>3],
        ['title'=>'第二球','code'=>'grp_2','sort'=>4],
        ['title'=>'第三球','code'=>'grp_3','sort'=>5],
        ['title'=>'第四球','code'=>'grp_4','sort'=>6],
        ['title'=>'第五球','code'=>'grp_5','sort'=>7],
    ];

    protected $default_schedules = [
        ['start_time'=>'08:00:00','total'=>960,'interval'=>75,'ahead'=>'10', 'sort'=>'1'],
    ];

    private function numbers(){
        return [mt_rand(0, 9),mt_rand(0, 9),mt_rand(0, 9),mt_rand(0, 9),mt_rand(0, 9)];
    }
    protected function generateNumbers()
    {
        $now_date = date('Y-m-d H:i:s');
        $issueObj = DB::table($this->issue_table)->where([['game_id',$this->pk],['open_time','<',$now_date]])->orderBy('open_time','desc')->first();
        if(empty($issueObj->issue)){
            return ajax_return(0,'没有正在开奖的期数');
        }
        //4.是否已经存在该期的开奖记录
        $exists = DB::table($this->lottery->table_lottery)->where(['game_id'=>$this->pk,'issue'=>$issueObj->issue])->first();
        if(isset($exists->sum) && $exists->sum > 0){
            $msg = sprintf('已存在开奖结果: %s期【%s】',$exists->issue,$this->lottery->title);
            return ajax_return(0,$msg);
        }
        //5.采集数据
        $numbers = $this->numbers();
        return  [
            'open_time' => $issueObj->open_time,
            'issue' => $issueObj->issue,
            'numbers' => [
                'no_1' => $numbers[0],
                'no_2' => $numbers[1],
                'no_3' => $numbers[2],
                'no_4' => $numbers[3],
                'no_5' => $numbers[4],
            ]
        ];
    }

    public function lotteryOption()
    {
        return $this->optionKeys();
    }

    protected function parseLottery($issue,$numbers=[])
    {
        $this->initailizeRule($this->pk,$issue,$numbers);
        $batch = $this->parseNumbers();
        return $batch;
    }

}
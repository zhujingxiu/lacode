<?php

namespace App\Libs\Game\Lottery;
use App\Libs\Game\BaseGame;
use App\Libs\Game\Traits\RuleSsc5;
use \DB;
class GameCqssc extends BaseGame
{
    use RuleSsc5;
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
        ['start_time'=>'00:10:00','total'=>9,'interval'=>20*60,'ahead'=>'35', 'sort'=>'1'],
        ['start_time'=>'07:10:00','total'=>50,'interval'=>20*60,'ahead'=>'35', 'sort'=>'2'],
    ];

    public function lotteryOption()
    {
        return $this->optionKeys();
    }

    protected function generateNumbers()
    {
        //3.采集数据
        $_api_url = 'https://www.ss1300.com:8090/api/newest?code=cq_ssc&t=' . time();
        $result = http_curl($_api_url);
        if(is_string($result)){
            $result = json_decode($result, TRUE);
        }
        if (!empty($result['code']) || !isset($result['data']) || !isset($result['data']['newest']) || !isset($result['data']['newest']['array'])) {
            return ajax_return(0,'开奖数据采集异常，数据不完整！-> '.$_api_url);
        }
        $numbers = $result['data']['newest']['array'];
        if (count($numbers) != 5) {
            return ajax_return(0,'开奖数据采集异常，号码长度错误！-> '.$_api_url);
        }
        $issue = $result['data']['newest']['issue'];
        return [
            'url' => $_api_url,
            'open_time' => $result['data']['newest']['time'],
            'issue' => $issue,
            'numbers' => [
                'no_1' => $numbers[0],
                'no_2' => $numbers[1],
                'no_3' => $numbers[2],
                'no_4' => $numbers[3],
                'no_5' => $numbers[4],
            ]
        ];

    }

    protected function parseLottery($issue,$numbers=[])
    {
        $this->initailizeRule($this->pk,$issue,$numbers);
        $batch = $this->parseNumbers();
        return $batch;
    }
}
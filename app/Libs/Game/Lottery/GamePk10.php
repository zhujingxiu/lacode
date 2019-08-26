<?php

namespace App\Libs\Game\Lottery;
use App\Libs\Game\BaseGame;
use App\Libs\Game\Traits\RuleSc10;

class GamePk10 extends BaseGame
{
    use RuleSc10;
    protected $default_issue_prefix = [
        'base' => '730667', 'date' => '2019-03-12'
    ];
    protected $default_issue_suffix_length = FALSE;

    protected $default_schedules = [
        ['start_time'=>'09:10:00','total'=>44,'interval'=>20*60,'ahead'=>'35', 'sort'=>'1'],
    ];

    protected $default_bets = [
        ['title'=>'1','code'=>'bet_1','sort'=>1,'style'=>'ball-num'],
        ['title'=>'2','code'=>'bet_2','sort'=>1,'style'=>'ball-num'],
        ['title'=>'3','code'=>'bet_3','sort'=>1,'style'=>'ball-num'],
        ['title'=>'4','code'=>'bet_4','sort'=>1,'style'=>'ball-num'],
        ['title'=>'5','code'=>'bet_5','sort'=>1,'style'=>'ball-num'],
        ['title'=>'6','code'=>'bet_6','sort'=>1,'style'=>'ball-num'],
        ['title'=>'7','code'=>'bet_7','sort'=>1,'style'=>'ball-num'],
        ['title'=>'8','code'=>'bet_8','sort'=>1,'style'=>'ball-num'],
        ['title'=>'9','code'=>'bet_9','sort'=>1,'style'=>'ball-num'],
        ['title'=>'10','code'=>'bet_10','sort'=>1,'style'=>'ball-num'],
        ['title'=>'11','code'=>'bet_11','sort'=>1,'style'=>'ball-num'],
        ['title'=>'12','code'=>'bet_12','sort'=>1,'style'=>'ball-num'],
        ['title'=>'13','code'=>'bet_13','sort'=>1,'style'=>'ball-num'],
        ['title'=>'14','code'=>'bet_14','sort'=>1,'style'=>'ball-num'],
        ['title'=>'15','code'=>'bet_15','sort'=>1,'style'=>'ball-num'],
        ['title'=>'16','code'=>'bet_16','sort'=>1,'style'=>'ball-num'],
        ['title'=>'17','code'=>'bet_17','sort'=>1,'style'=>'ball-num'],
        ['title'=>'18','code'=>'bet_18','sort'=>1,'style'=>'ball-num'],
        ['title'=>'19','code'=>'bet_19','sort'=>1,'style'=>'ball-num'],
        ['title'=>'大','code'=>'bet_da','sort'=>1,'style'=>''],
        ['title'=>'小','code'=>'bet_x','sort'=>1,'style'=>''],
        ['title'=>'單','code'=>'bet_d','sort'=>1,'style'=>''],
        ['title'=>'雙','code'=>'bet_s','sort'=>1,'style'=>''],
        ['title'=>'冠、亞大','code'=>'bet_zhd','sort'=>1,'style'=>''],
        ['title'=>'冠、亞小','code'=>'bet_zhx','sort'=>1,'style'=>''],
        ['title'=>'冠、亞單','code'=>'bet_zhda','sort'=>1,'style'=>''],
        ['title'=>'冠、亞雙','code'=>'bet_zhs','sort'=>1,'style'=>''],
        ['title'=>'龍','code'=>'bet_long','sort'=>1,'style'=>''],
        ['title'=>'虎','code'=>'bet_hu','sort'=>1,'style'=>''],
        ['title'=>'和','code'=>'bet_he','sort'=>1,'style'=>''],
    ];

    protected $default_options = [
        ['trait'=>'special','title'=>'冠军','code'=>'opt_1','sort'=>1,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'亞軍','code'=>'opt_2','sort'=>2,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第三名','code'=>'opt_3','sort'=>3,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第四名','code'=>'opt_4','sort'=>4,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第五名','code'=>'opt_5','sort'=>5,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第六名','code'=>'opt_6','sort'=>6,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第七名','code'=>'opt_7','sort'=>7,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第八名','code'=>'opt_8','sort'=>8,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第九名','code'=>'opt_9','sort'=>9,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'special','title'=>'第十名','code'=>'opt_10','sort'=>10,'diff_b'=>'0.2','diff_c'=>'0.3'],
        ['trait'=>'double','title'=>'1-10大小','code'=>'opt_dx','sort'=>11,'diff_b'=>'0.04','diff_c'=>'0.06'],
        ['trait'=>'double','title'=>'1-10單雙','code'=>'opt_ds','sort'=>12,'diff_b'=>'0.04','diff_c'=>'0.06'],
        ['trait'=>'double','title'=>'1-5龍虎','code'=>'opt_lh','sort'=>13,'diff_b'=>'0.04','diff_c'=>'0.06'],
        ['trait'=>'double','title'=>'冠、亞軍和','code'=>'opt_gyh','sort'=>14,'diff_b'=>'0.8','diff_c'=>'1.2'],
        ['trait'=>'double','title'=>'冠亞和大小','code'=>'opt_gyhdx','sort'=>15,'diff_b'=>'0.04','diff_c'=>'0.06'],
        ['trait'=>'double','title'=>'冠亞和單雙','code'=>'opt_gyhds','sort'=>16,'diff_b'=>'0.04','diff_c'=>'0.06'],
    ];

    protected $default_groups = [
        ['title'=>'兩面盤','code'=>'grp_sm','sort'=>1],
        ['title'=>'單球1-10','code'=>'grp_dq','sort'=>2],
        ['title'=>'冠、亞軍 組合','code'=>'grp_gy','sort'=>3],
        ['title'=>'三、四、五、六名','code'=>'grp_3456','sort'=>4],
        ['title'=>'七、八、九、十名','code'=>'grp_78910','sort'=>5],
    ];


    protected function generateNumbers()
    {
        //3.采集数据
        $_api_url = 'https://www.ss1300.com:8090/api/newest?code=pk10&t=' . time();

        $result = http_curl($_api_url);

        if (!empty($result['code']) || !isset($result['data']) || !isset($result['data']['newest']) || !isset($result['data']['newest']['array'])) {

            return ajax_return(0,'开奖数据采集异常，数据不完整！-> '.$_api_url);
        }
        $numbers = $result['data']['newest']['array'];
        if (count($numbers) != 10) {
            return ajax_return(0,'开奖数据采集异常，号码长度错误！-> '.$_api_url);
        }

        return [
            'url' => $_api_url,
            'open_time' => $result['data']['newest']['time'],
            'issue' => $result['data']['newest']['issue'],
            'numbers' => [
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
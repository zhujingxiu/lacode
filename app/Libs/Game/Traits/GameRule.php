<?php

namespace App\Libs\Game\Traits;


trait GameRule
{
    protected $game_id;
    protected $issue;
    protected $numbers;
    protected $info_batch;
    protected $sum_value;
    protected $zonghe_key = 'zonghe';
    protected $daxiao_key = 'daxiao';
    protected $danshuang_key = 'danshuang';
    protected $longhuhe_key = 'longhuhe';
    protected $da_key = 'da';
    protected $xiao_key = 'xiao';
    protected $dan_key = 'dan';
    protected $shuang_key = 'shuang';
    protected $long_key = 'long';
    protected $hu_key = 'hu';
    protected $he_key = 'he';
    protected $guanya_key = 'guanya';
    protected $guanya_value;
    protected $issue_table = 'game_schedule_issues';


    public function initailizeRule($game_id, $issue, $numbers)
    {
        $this->game_id = $game_id;
        $this->issue = $issue;
        // 4.更新采集开奖时间为预定时间
        $issueObj = \DB::table($this->issue_table)->where(['game_id'=>$this->game_id,'issue'=>$issue])->first();
        if(!empty($issueObj->issue)){
            $this->addInfo('open_time',$issueObj->open_time);
        }

        $this->numbers = $numbers;
        $this->sum_value = array_sum($numbers);

        $this->no_1 = isset($this->numbers['no_1']) ? $this->numbers['no_1'] : '';
        $this->no_2 = isset($this->numbers['no_2']) ? $this->numbers['no_2'] : '';
        $this->no_3 = isset($this->numbers['no_3']) ? $this->numbers['no_3'] : '';
        $this->no_4 = isset($this->numbers['no_4']) ? $this->numbers['no_4'] : '';
        $this->no_5 = isset($this->numbers['no_5']) ? $this->numbers['no_5'] : '';
        $this->no_6 = isset($this->numbers['no_6']) ? $this->numbers['no_6'] : NULL;
        $this->no_7 = isset($this->numbers['no_7']) ? $this->numbers['no_7'] : NULL;
        $this->no_8 = isset($this->numbers['no_8']) ? $this->numbers['no_8'] : NULL;
        $this->no_9 = isset($this->numbers['no_9']) ? $this->numbers['no_9'] : NULL;
        $this->no_10 = isset($this->numbers['no_10']) ? $this->numbers['no_10'] : NULL;

        $this->guanya_value = $this->no_1 + $this->no_2;
    }

    protected function addInfo($key, $value)
    {
        $this->info_batch[] = [
            'issue'=> $this->issue,
            'game_id'=> $this->game_id,
            'g_key'=>$key,
            'g_value'=>$value,
        ];
    }

    protected function getNoKey($key)
    {
        return $key;
    }

    protected function getLongHuHeKey($key=FALSE)
    {
        if($key==FALSE){
            return $this->longhuhe_key;
        }else{
            return $key.'_'.$this->longhuhe_key;
        }
    }

    public function getLongHuHeValue($value1, $value2)
    {
        if($value1 == $value2){
            return $this->he_key;
        }
        return $value1 > $value2 ? $this->long_key : $this->hu_key;
    }

    protected function getDaxiaoKey($key=FALSE)
    {
        if($key==FALSE){
            return $this->zonghe_key.'_'.$this->daxiao_key;
        }else{
            return $key.'_'.$this->daxiao_key;
        }

    }

    protected function getDanshuangKey($key=FALSE)
    {
        if($key==FALSE){
            return $this->zonghe_key.'_'.$this->danshuang_key;
        }else{
            return $key.'_'.$this->danshuang_key;
        }
    }

    public function getDaXiaoValue($value1 ,$value2)
    {
        return $value1 > $value2 ? $this->da_key : $this->xiao_key;
    }

    public function getDanShuangValue($value)
    {
        return ($value%2) ? $this->dan_key : $this->shuang_key;
    }

    public function getZongheKey()
    {
        return $this->zonghe_key;
    }

    protected function ascNumber($values,$step=1)
    {
        $prev_value = FALSE;
        foreach ($values as $value){
            if($prev_value===FALSE){
                $prev_value = $value;
                continue;
            }
            if($prev_value+$step != $value){
                return FALSE;
            }
            $prev_value += $step;
        }
        return True;
    }

    public function getText($key)
    {

    }
}
<?php
namespace App\Libs\Game\Traits;


trait RuleSsc5
{
    use GameRule;

    protected $no_1;
    protected $no_2;
    protected $no_3;
    protected $no_4;
    protected $no_5;

    protected $min_sum = 23;
    protected $min_no_value = 4;
    protected $qiansan_key = 'qiansan';
    protected $zhongsan_key = 'zhongsan';
    protected $housan_key = 'housan';
    protected $baozi_key = 'baozi';
    protected $shunzi_key = 'shunzi';
    protected $duizi_key = 'duizi';
    protected $banshun_key = 'banshun';
    protected $zaliu_key = 'zaliu';


    public function parseNumbers()
    {
        //1-5大小单双
        foreach ($this->numbers as $key => $value) {
            $this->addInfo($this->getNoKey($key),$value);
            //大小
            $this->addInfo($this->getDaxiaoKey($key),$this->getDaXiaoValue($value,$this->min_no_value));
            //单双
            $this->addInfo($this->getDanshuangKey($key),$this->getDanShuangValue($value));
        }
        //总和
        $this->addInfo($this->getZongheKey(),$this->sum_value);
        //总和大小
        $this->addInfo($this->getDaxiaoKey(),$this->getDaXiaoValue($this->sum_value,$this->min_sum));
        //总和单双
        $this->addInfo($this->getDanshuangKey(),$this->getDanShuangValue($this->sum_value));
        //龙虎和
        $this->addInfo($this->getLongHuHeKey(),$this->getLongHuHeValue($this->no_1, $this->no_5));
        //前三
        $this->addInfo($this->getQiansanKey(),$this->getQiansanValue());
        //中三
        $this->addInfo($this->getZhongsanKey(),$this->getZhongsanValue());
        //后三
        $this->addInfo($this->getHousanKey(),$this->getHousanValue());

        return $this->info_batch;
    }

    /**
     * 豹子 > 顺子 > 对子 > 半顺 > 杂六
     *
     * 豹子：中獎號碼的给定连续的三个号码數字都相同。----如中獎號碼為000、111、999等，中獎號碼的给定连续的三个号码數字相同，則投註豹子者視為中獎，其它視為不中獎。
     * 順子：中獎號碼的给定连续的三个号码數字都相連，不分順序。（數字9、0、1相連）----如中獎號碼為123、901、321、546等，中獎號碼给定连续的三个号码數字相連，則投註順子者視為中獎，其它視為不中獎。
     * 對子：中獎號碼的给定连续的三个号码任意兩位數字相同。（不包括豹子）----如中獎號碼為001，112、696，中獎號碼有兩位數字相同，則投註對子者視為中獎，其它視為不中獎。如果開獎號碼為豹子,則對子視為不中獎。如中獎號碼為001，112、696，中獎號碼有兩位數字相同，則投註對子者視為中獎，其它視為不中獎。
     * 半順：中獎號碼的给定连续的三个号码任意兩位數字相連，不分順序。（不包括順子、對子。）----如中獎號碼為125、540、390、706，中獎號碼有兩位數字相連，則投註半順者視為中獎，其它視為不中獎。如果開獎號碼為順子、對子,則半順視為不中獎。--如中獎號碼為123、901、556、233，視為不中獎。
     * 雜六：不包括豹子、對子、順子、半順的所有中獎號碼。----如中獎號碼為157，中獎號碼位數之間無關聯性，則投註雜六者視為中獎，其它視為不中獎。
     * @param $value1
     * @param $value2
     * @param $value3
     * @return string
     */
    protected function getThreeValue($value1, $value2, $value3)
    {
        if($value1 == $value2 and $value2 == $value3){
            return $this->baozi_key;
        }
        if ($value1 == $value2 || $value1 == $value3 ||  $value2 == $value3)
            return $this->duizi_key;
        $sort_array = [$value1,$value2,$value3];
        sort($sort_array);
        $a = join('',$sort_array);
        if(in_array($a,['019','089']) || $this->ascNumber($sort_array)){
            return $this->shunzi_key;
        }

        if (preg_match('/.09|0.9/', $a) || $sort_array[0]+1 == $sort_array[1] || $sort_array[1]+1 == $sort_array[2]) {
            return $this->banshun_key;
        }

        return $this->zaliu_key;
    }

    /**
     * 前三位数
     * @return string
     */
    protected function getQiansanKey()
    {
        return $this->qiansan_key;
    }
    protected function getQiansanValue()
    {
        return $this->getThreeValue($this->no_1, $this->no_2, $this->no_3);
    }

    /**
     * 中间三位数
     * @return string
     */
    protected function getZhongsanKey()
    {
        return $this->zhongsan_key;
    }


    protected function getZhongsanValue()
    {
        return $this->getThreeValue($this->no_2, $this->no_3, $this->no_4);
    }
    /**
     * 后三位数
     * @return string
     */
    protected function getHousanKey()
    {
        return $this->housan_key;
    }
    protected function getHousanValue()
    {
        return $this->getThreeValue($this->no_3, $this->no_4, $this->no_5);
    }

    public function optionKeys()
    {
        return [
            'numbers'=>['text'=>'開出號碼','children'=>[
                ['key'=>'no_1','style'=>['class'=>'No_cq','merge'=>TRUE],'text'=>FALSE,'title'=>'第一球'],
                ['key'=>'no_2','style'=>['class'=>'No_cq','merge'=>TRUE],'text'=>FALSE,'title'=>'第二球'],
                ['key'=>'no_3','style'=>['class'=>'No_cq','merge'=>TRUE],'text'=>FALSE,'title'=>'第三球'],
                ['key'=>'no_4','style'=>['class'=>'No_cq','merge'=>TRUE],'text'=>FALSE,'title'=>'第四球'],
                ['key'=>'no_5','style'=>['class'=>'No_cq','merge'=>TRUE],'text'=>FALSE,'title'=>'第五球']
            ]],
            'zonghe' => ['text'=>'總和','children'=>[
                ['key'=>$this->getZongheKey()],
                ['key'=>$this->getDaxiaoKey(),'trans'=>TRUE],
                ['key'=>$this->getDanshuangKey(),'trans'=>TRUE]
            ]],
            'longhu' => ['text'=>'龍虎','children'=>[
                ['key'=>$this->getLongHuHeKey(),'trans'=>TRUE]
            ]],
            'qiansan' => ['text'=>'前三','children'=>[
                ['key'=>$this->getQiansanKey(),'trans'=>TRUE]
            ]],
            'zhongsan' => ['text'=>'中三','children'=>[
                ['key'=>$this->getZhongsanKey(),'trans'=>TRUE]
            ]],
            'housan' => ['text'=>'后三','children'=>[
                ['key'=>$this->getHousanKey(),'trans'=>TRUE]
            ]],
        ];
    }

}
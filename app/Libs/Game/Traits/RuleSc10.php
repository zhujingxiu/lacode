<?php

namespace App\Libs\Game\Traits;


trait RuleSc10
{
    use GameRule;

    protected $no_1;
    protected $no_2;
    protected $no_3;
    protected $no_4;
    protected $no_5;
    protected $no_6;
    protected $no_7;
    protected $no_8;
    protected $no_9;
    protected $no_10;

    protected $min_guanya_value = 11;
    protected $min_no_value = 6;


    protected function getGuanyaKey()
    {
        return $this->guanya_key;
    }


    public function parseNumbers()
    {
        $zonghe_key = $this->getGuanyaKey();
        //1-5大小单双
        foreach ($this->numbers as $key => $value) {
            $this->addInfo($this->getNoKey($key), $value);
            //大小
            $this->addInfo($this->getDaxiaoKey($key), $this->getDaXiaoValue($value, $this->min_no_value));
            //单双
            $this->addInfo($this->getDanshuangKey($key), $this->getDanShuangValue($value));

            //1-5龙虎和
            $longhu_key = $this->getLongHuHeKey($key);
            if ($key == 'no_1') {
                $this->addInfo($longhu_key, $this->getLongHuHeValue($this->no_1, $this->no_10));
            }
            if ($key == 'no_2') {
                $this->addInfo($longhu_key, $this->getLongHuHeValue($this->no_2, $this->no_9));
            }
            if ($key == 'no_3') {
                $this->addInfo($longhu_key, $this->getLongHuHeValue($this->no_3, $this->no_8));
            }
            if ($key == 'no_4') {
                $this->addInfo($longhu_key, $this->getLongHuHeValue($this->no_4, $this->no_7));
            }
            if ($key == 'no_5') {
                $this->addInfo($longhu_key, $this->getLongHuHeValue($this->no_5, $this->no_6));
            }
        }
        //冠亚和
        $this->addInfo($zonghe_key, $this->guanya_value);
        //冠亚和大小
        $this->addInfo($this->getDaxiaoKey($zonghe_key), $this->getDaXiaoValue($this->guanya_value, $this->min_guanya_value));
        //冠亚和单双
        $this->addInfo($this->getDanshuangKey($zonghe_key), $this->getDanShuangValue($this->guanya_value));

        return $this->info_batch;
    }

    /**
     * 默认使用北京pk10
     * @return array
     */
    public function optionKeys()
    {
        $guanya_key = $this->getGuanyaKey();
        return [
            'numbers' => ['text' => '開出號碼', 'children' => [
                ['key' => 'no_1','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'冠军'],
                ['key' => 'no_2','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'亚军'],
                ['key' => 'no_3','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'第三名'],
                ['key' => 'no_4','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'第四名'],
                ['key' => 'no_5','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'第五名'],
                ['key' => 'no_6','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'第六名'],
                ['key' => 'no_7','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'第七名'],
                ['key' => 'no_8','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'第八名'],
                ['key' => 'no_9','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'第九名'],
                ['key' => 'no_10','style'=>['class'=>'No_','merge'=>TRUE],'text'=>FALSE,'title'=>'第十名']
            ]],
            'guanyajunhe' => ['text' => '冠亞軍和', 'children' => [
                ['key' => $guanya_key],
                ['key' => $this->getDaxiaoKey($guanya_key),'trans'=>TRUE],
                ['key' => $this->getDanshuangKey($guanya_key),'trans'=>TRUE]
            ]],
            'longhu1-5' => ['text' => '1～5 龍虎', 'children' => [
                ['key' => $this->getLongHuHeKey('no_1'),'trans'=>TRUE],
                ['key' => $this->getLongHuHeKey('no_2'),'trans'=>TRUE],
                ['key' => $this->getLongHuHeKey('no_3'),'trans'=>TRUE],
                ['key' => $this->getLongHuHeKey('no_4'),'trans'=>TRUE],
                ['key' => $this->getLongHuHeKey('no_5'),'trans'=>TRUE]
            ]],
        ];
    }

}
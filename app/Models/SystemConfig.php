<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    //
    public $timestamps = FALSE;
    public function item($key)
    {
        $item = $this->where(['g_key'=>$key])->first();
        if(!$item){
            return '';
        }
        switch(strtolower($item['mode'])){
            case 'json':
                return json_encode($item['g_value']);
            case 'serializable':
                return unserialize($item['g_value']);
            default:
                return $item['g_value'];
        }
    }
}

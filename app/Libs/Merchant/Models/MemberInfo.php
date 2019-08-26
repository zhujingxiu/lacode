<?php
namespace App\Libs\Merchant\Models;

use App\Models\Model;
class MemberInfo extends Model
{
    //
    public $timestamps = FALSE;

    public static function rebatesOptions()
    {
        return [
            '0' => '水全退到底',
            '0.3' => '赚取0.3退水',
            '0.5' => '赚取0.5退水',
            '1.0' => '赚取1.0退水',
            '2.0' => '赚取2.0退水',
            '2.5' => '赚取2.5退水',
            '100' => '赚取所有退水',
        ];
    }
}

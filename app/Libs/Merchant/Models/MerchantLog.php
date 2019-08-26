<?php
namespace App\Libs\Merchant\Models;

use App\Models\Model;
class MerchantLog extends Model
{
    //
    public $timestamps = FALSE;
    protected $fillable = ['role','user_id','path','ip','locate','note','created_at'];

}

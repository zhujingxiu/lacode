<?php
namespace App\Libs\Merchant\Models;

use App\Models\Model;
class MerchantHistory extends Model
{
    //
    protected $table = 'merchant_history';
    public $timestamps = FALSE;
    protected $fillable = ['role','user_id','action','data','request','ip','locate','note','created_at'];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);

    }
}

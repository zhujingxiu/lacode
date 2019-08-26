<?php

namespace App\Libs\Merchant\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Member extends Authenticatable implements JWTSubject
{
    //
    use Notifiable;
    protected $fillable = [
        'name', 'password','admin_id','uid','reset','online','last_ip','status','nick_name','merchant_id'
    ];
    protected $hidden = [
        'password',
    ];
    public $remember_token = '';

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function info()
    {
        return $this->hasOne(MemberInfo::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class,'merchant_id');
    }

    public function rebates()
    {
        return $this->hasMany(MerchantRebate::class,'user_id');
    }

    public function history()
    {
        return $this->hasMany(MerchantHistory::class,'user_id');
    }
}

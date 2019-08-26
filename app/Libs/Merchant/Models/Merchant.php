<?php

namespace App\Libs\Merchant\Models;

use App\Models\SystemRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Merchant extends Authenticatable
{
    //
    use Notifiable;
    protected $fillable = [
        'name', 'password','admin_id','uid','reset','online','last_ip','status','nick_name','parent_id'
    ];
    protected $hidden = [
        'password',
    ];
    public $remember_token = '';

    public function info()
    {
        return $this->hasOne(MerchantInfo::class);
    }

    public function role()
    {
        return $this->belongsTo(SystemRole::class);
    }

    public function games()
    {
        return $this->hasMany(MerchantGame::class);
    }
    public function history()
    {
        return $this->hasMany(MerchantHistory::class, 'user_id');
    }

    public function children()
    {
        return $this->hasMany(get_class($this), 'parent_id');
    }

//    public function referralMerchants()
//    {
//        return $this->children()->with('referralMerchants');
//    }

    public function referralMerchantsCount()
    {
        $result = [];
        $children = $this->children;

        foreach ($children as $child) {
            $child->load('role');
            $result[] = $child->toArray();

            $childResult = $child->referralMerchantsCount();
            foreach ($childResult as $subChild) {
                $result[] = $subChild;
            }
        }

        return $result;
    }

    public function referralMerchantCountByRole()
    {
        $referrers = $this->referralMerchantsCount();
        if(!$referrers){
            return FALSE;
        }
        $result = [];
        foreach ($referrers as $merchant)
        {
            $result[$merchant['role']['code']][] = $merchant;
        }
        return $result;
    }

    public function parent()
    {
        return $this->belongsTo(get_class($this),'parent_id');
    }

    public function rebates()
    {
        return $this->hasMany(MerchantRebate::class,'user_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function referralShareholders()
    {
        return $this->hasMany(MerchantRelation::class);
    }

    public function referralAgents()
    {
        return $this->hasMany(MerchantRelation::class);
    }

    public function referralProxies()
    {
        return $this->hasMany(MerchantRelation::class);
    }

    public function referralMembers()
    {
        return $this->hasMany(MerchantRelation::class);
    }
}

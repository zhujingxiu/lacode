<?php

namespace App\Models;

class SystemPermission extends Model
{
    //
    public $timestamps = FALSE;
    protected $fillable = ['title','parent','method','action','path','auth','log','status','role'];

    /*
     * 权限属于哪些角色
     */
    public function roles()
    {
        return $this->belongsToMany(SystemRole::class, 'system_role_permission', 'permission_id', 'role_id')->withPivot(['permission_id', 'role_id']);
    }
}

<?php

namespace App\Models;

class SystemRole extends Model
{
    public $timestamps= FALSE;

    /*
     * 当前角色的所有下的所有用户
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_role_admin', 'role_id', 'admin_id')->withPivot(['admin_id', 'role_id']);
    }

    public function merchants()
    {
        return $this->hasMany(\App\Libs\Merchant\Models\Merchant::class,'role_id');
    }

    /*
     * 当前角色的所有权限
     */
    public function permissions()
    {
        return $this->belongsToMany(SystemPermission::class, 'system_role_permission', 'role_id', 'permission_id')->withPivot(['permission_id', 'role_id']);
    }

    /*
     * 给角色授权
     */
    public function grantPermission($permission)
    {
        return $this->permissions()->save($permission);
    }

    /*
     * 删除role和permission的关联
     */
    public function deletePermission($permission)
    {
        return $this->permissions()->detach($permission);
    }

    /*
     * 角色是否有权限
     */
    public function hasPermission($permission)
    {
        return $this->permissions->contains($permission);
    }

    public function parentMerchantRole()
    {
        $parent_code = FALSE;
        switch (strtolower($this->code)){
            case 'shareholder':
                $parent_code = 'company';
                break;
            case 'agent':
                $parent_code = 'shareholder';
                break;
            case 'proxy':
                $parent_code = 'agent';
                break;
        }
        return SystemRole::where('code', $parent_code)->firstOrFail();
    }
}

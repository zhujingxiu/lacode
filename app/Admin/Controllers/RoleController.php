<?php

namespace App\Admin\Controllers;
use App\Admin\Admin;
use App\Models\SystemRole;
use App\Models\SystemPermission;
use App\Admin\Requests\FormAdmin;
class RoleController extends Controller
{
    /*
     * 用户列表
     */
    public function index()
    {
        $page_title = '角色管理';
        $roles = SystemRole::whereNotIn('code',['superoot'])->paginate(10);
        return view('/admin/permission/role', compact('page_title','roles'));
    }

    public function managers($role_code)
    {
        $role = SystemRole::where(['code'=>$role_code])->first();
        $users = $role->admins;
        $page_title = '用户管理 - '.$role->name;
        return view('admin.permission.user', compact('page_title', 'role','users'));
    }

    public function newUser(FormAdmin $request)
    {
        $admin = \Auth::guard('admin')->user();
        $user = [
            'name' => $request->input('name'),
            'nick_name' => $request->input('nick_name'),
            'admin_id' => $admin->id,
            'reset' => 1,
            'password' => bcrypt(trim($request->input('password'))),
        ];
        //入库
        $newAdmin = Admin::create($user);
        if($newAdmin) {
            $role = SystemRole::where(['code' => $request->input('code')])->first();
            $newAdmin->roles()->attach($role->id);
            //返回
            return ajax_return(1, '添加用户【'.$newAdmin->name.'】成功');
        }
        //返回
        return ajax_return(0);
    }
    /*
     * 创建角色
     */
    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:3',
            'description' => 'required',
        ]);

        SystemRole::create(request(['name', 'description']));
        return redirect(route('admin.role'));
    }

    /*
     * 角色的权限
     */
    public function permission(SystemRole $role)
    {
        $myPermissions = $role->permissions;
        $had_permissions = $myPermissions->groupBy('id')->keys()->toArray();
        $permissions = [];
        $stored_routes = SystemPermission::where('role',$role->role)->orderBy('parent')->get();
        foreach ($stored_routes as $key=>$item){
            if($item['parent']==0){
                $parent_keys[$item['id']] = $item['title'];
                $permissions[$item['title']] = [] ;
                continue;
            }
            $item['selected'] = boolval(in_array($item['id'], $had_permissions));
            $item['title'] = trim($item['title']);
            if(empty($item['title'])){
                $item['title'] = $item['path'];
            }
            $permissions[$parent_keys[$item['parent']]][] = $item;
        }
        $role->form_action = route('admin.role-permissions', $role->id);
        return  ajax_return(1,compact('permissions', 'role'));
    }

    /*
     * 保存权限
     */
    public function storePermission(SystemRole $role)
    {
        $this->validate(request(),[
            'permissions' => 'required|array'
        ]);

        $permissions = SystemPermission::find(request('permissions'));
        $myPermissions = $role->permissions;

        // 对已经有的权限
        $addPermissions = $permissions->diff($myPermissions);
        foreach ($addPermissions as $permission) {
            $role->grantPermission($permission);
        }

        $deletePermissions = $myPermissions->diff($permissions);
        foreach ($deletePermissions as $permission) {
            $role->deletePermission($permission);
        }
        return [
            'error_code' => 0
        ];
    }
}
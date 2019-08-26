<?php
namespace App\Admin\Controllers;

use App\Models\SystemPermission;
class PermissionController extends Controller
{
    /*
     * 权限节点列表
     */
    protected $route_prefix = ['admin','merchant'];
    public function index()
    {
        $page_title = '权限节点';

        return view('/admin/permission/index', compact('page_title'));
    }

    /*
     * 创建权限节点
     */
    public function create()
    {
        return view('/admin/permission/add');
    }

    /*
     * 创建权限节点
     */
    public function store()
    {
        // 解析form.serialize()过来的数据
        parse_str(request('permission'), $permission);
        if(request('stored')){
            SystemPermission::truncate();
        }
        if(isset($permission['perm'])){
            foreach ($permission['perm'] as $item){
                $perm = SystemPermission::firstOrCreate(['role'=>$item['role'],'title'=>$item['parent']]);
                if(!isset($item['auth'])){
                    $item['auth'] = 0;
                }
                if(!isset($item['log'])){
                    $item['log'] = 0;
                }
                if(!isset($item['status'])){
                    $item['status'] = 0;
                }
                $item['parent'] = $perm['id'];
                SystemPermission::create($item);
            }
            return ajax_return();
        }

        return ajax_return(0);
    }

    public function routes()
    {
        $mode = request('mode');
        $permissions = [];
        $stored_routes = SystemPermission::orderBy('parent')->get();
        if($mode=='stored'){
            foreach ($stored_routes as $key=>$item){
                if($item['parent']==0){
                    $parent_keys[$item['id']] = $item['title'];
                    $permissions[$item['title']] = [] ;
                    continue;
                }
                $permissions[$parent_keys[$item['parent']]][] = $item;
            }
        }else {
            $parent_keys = [];
            $store_keys = [];

            foreach ($stored_routes as $item) {
                if ($item['parent'] == 0) {
                    $parent_keys[$item['id']] = $item['name'];
                    continue;
                }
                $store_keys[] = sprintf('%s@%s@%s', $parent_keys[$item['parent']], $item['action'], $item['method']);
            }
            $routes = (app())->routes->getRoutes();

            foreach ($routes as $value) {

                $_action = $value->action;
                if(!isset($_action['controller'])){
                    continue;
                }
                $_builds = explode('/',strtolower($value->uri));
                if(!isset($_builds[0])){
                    continue;
                }
                $_role = trim($_builds[0]);
                if($_role=='xadmin'){
                    $_role = 'admin';
                }
                if($_role=='xmerchant'){
                    $_role = 'merchant';
                }
                if(!in_array($_role,$this->route_prefix)){
                    continue;
                }
                $controller_and_action = explode('@', $_action['controller']);
                $controller = $controller_and_action[0];
                $action = $controller_and_action[1];
                $head_key = array_search('HEAD',$value->methods);
                if($head_key!==FALSE){
                    unset($value->methods[$head_key]);
                }
                foreach ($value->methods as $_method) {
                    $route_key = sprintf('%s@%s@%s', $controller, $action, $_method);
                    if (in_array($route_key, $store_keys)) {
                        continue;
                    }
                    $permissions[$controller][] = [
                        'role' => $_role,
                        'path' => $value->uri,
                        'method' => $_method,
                        'action' => $action,
                    ];
                }
            }
        }
        return ajax_return(1,compact('permissions'));
    }
}
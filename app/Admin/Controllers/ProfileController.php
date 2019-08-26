<?php
namespace App\Admin\Controllers;

use App\Admin\Requests\ResetPassword;
use App\Models\LoginLog;
class ProfileController extends Controller
{

    public function index()
    {
        $page_title = '个人信息';
        return view('admin.profile.index', compact('page_title'));
    }

    public function password()
    {
        $page_title = '密码修改';
        return view('admin.profile.password', compact('page_title'));
    }

    public function reset(ResetPassword $request)
    {
        $admin = \Auth::guard('admin')->user();
        $admin->password = bcrypt($request['password']);
        $admin->save();
    }

    public function log()
    {
        $page_title = '登录日志';
        $admin = \Auth::guard('admin')->user();
        $logs = LoginLog::where(['admin_id'=>$admin->id])->paginate(10);
        return view('admin.profile.log', compact('page_title', 'logs'));
    }
}

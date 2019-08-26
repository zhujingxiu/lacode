<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public $guard = 'merchant';
    public function index()
    {
        return view($this->guard.'/login');
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:2',
            'password' => 'required|min:6|max:30',
            //'captcha' => 'required|captcha',
        ]);
        if (true == \Auth::guard($this->guard)->attempt(['name'=>$request->get('name'),'password'=>$request->get('password')])) {
            return redirect()->route($this->guard.'.home');
        }
        return \Redirect::back()->withErrors("用户名密码错误");
    }

    /*
     * 登出操作
     */
    public function logout()
    {
        \Auth::guard($this->guard)->logout();
        return redirect()->route($this->guard.'.login');
    }
}

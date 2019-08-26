<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
//        $v1 = 5;$v2= 4;$v3 = 0;
//        $v1 = 6;$v2= 4;$v3 = 5;
//        $sort_array = [$v1,$v2,$v3];
//        sort($sort_array);
//        $a = join('',$sort_array);
//        $b = preg_match('/.09|0.9/', $a);
//        var_dump($a);
//        var_dump($b);
//        var_dump($this->ascNumber($sort_array));
        return view('admin/login');
    }

    protected function ascNumber($values,$step=1)
    {
        $prev_value = FALSE;
        foreach ($values as $value){
            if($prev_value===FALSE){
                $prev_value = $value;
                continue;
            }
            if($prev_value+$step != $value){
                return FALSE;
            }
            $prev_value += $step;
        }
        return True;
    }

    public function login(Request $request)
    {
        $user = $this->validate($request, [
            'name' => 'required|min:2',
            'password' => 'required|min:6|max:30',
        ]);
        if (true == \Auth::guard('admin')->attempt($user)) {
            return redirect()->route('admin.home');
        }
        return \Redirect::back()->withErrors("用户名密码错误");
    }

    /*
     * 登出操作
     */
    public function logout()
    {
        \Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}

<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //

    public function index()
    {
        DB::table('game_schedule_issues')
            ->where([['game_id', 3], ['end_time', '<=', date('Y-m-d H:i:s')]])
            ->update(['status' => -1]);
        return view('member.login');
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'username' => 'required|min:2',
            'pwd' => 'required|min:6|max:30',
            //'captcha' => 'required|captcha',
        ]);
        if (true == \Auth::attempt(['name'=>$request->get('username'),'password'=>$request->get('pwd')])) {
            return redirect()->route('member.home');
        }
        return \Redirect::back()->withErrors("用户名密码错误");
    }
    public function logout()
    {
        \Auth::logout();
        return redirect()->route('member.login');
    }
}

<?php

namespace App\Http\Controllers\Merchant;

use App\Models\LoginLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResetPassword;
class ProfileController extends Controller
{
    //

    public function log()
    {
        $logs = LoginLog::where(['role'=>'merchant','uid'=>Auth::guard('merchant')->user()->id])->paginate($this->per_page);
        return view('merchant.profile.log',compact('logs'));
    }

    public function pwd()
    {
        return view('merchant.profile.pwd');
    }

    public function reset(ResetPassword $request)
    {
        $admin = \Auth::guard('merchant')->user();
        $admin->password = bcrypt($request['password']);
        $admin->save();
        return ajax_return(1);
    }
}

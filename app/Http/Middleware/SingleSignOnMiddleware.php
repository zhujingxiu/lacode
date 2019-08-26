<?php

namespace App\Http\Middleware;

use App\Libs\Merchant\Models\MerchantLog;
use App\Models\Menu;
use App\Models\SystemPermission;
use Closure;
use Hash;
use Symfony\Component\Routing\Route;
class SingleSignOnMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if($guard == 'admin'){
            $token_key = config('site.admin_login_token');
        }else if($guard == 'merchant'){
            $token_key = config('site.merchant_login_token');
        }else{
            $token_key = config('site.login_token');
        }
        \Session::put(config('site.login_guard'), $guard);
        $login_token = \Session::get($token_key);
        $user = \Auth::guard($guard)->user();
        if($user->login_token !== $login_token){
            $logout_route = 'member.logout';
            if($guard == 'admin'){
                $logout_route = 'admin.logout';
            }else if($guard == 'merchant'){
                $logout_route = 'merchant.logout';
            }
            $user->online = 0;
            $user->save();
            return redirect()->route($logout_route);
        }
        //更新在线状态
        if(!$user->online) {
            $user->online = 1;
            $user->save();
        }
        //记录访问页面
        if($guard=='merchant') {
            $url = '/'.ltrim($request->path(),'/');
            $menu = Menu::where('path', $url)->select('title')->first();
            if (!$menu) {
                //Route::find
            }
            $log = MerchantLog::select(['path','created_at'])->where(['role'=>$guard,'user_id'=> $user->id])->orderBy('created_at','desc')->first();
            //未记录过 或 前次有相同记录 但是时间间隔超过5分钟的

            if(!isset($log->path) || ($log->path != $url) || ($log->path == $url && (time() - strtotime($log->created_at)) > 5*60)) {
                $locate = ip_locate();
                MerchantLog::create([
                    'role' => $guard ? $guard : 'member',
                    'user_id' => $user->id,
                    'path' => $url,
                    'note' => empty($menu->title) ? '' : $menu->title,
                    'ip' => $locate ? $locate['ip'] : ip_addr(),
                    'locate' => $locate ? $locate['region'] . '.' . $locate['city'] . '-' . $locate['isp'] : '本机地址',
                    'created_at' => now()
                ]);
            }
        }
        return $next($request);
    }
}

<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoginEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function subscribe($event)
    {
        //
        $event->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserLoginEventSubscriber@onUserLogin'
        );
    }

    public function onUserLogin($event)
    {
        $role = 'member';
        $token_key = config('site.login_token');
        if($event->user instanceof \App\Libs\Merchant\Models\Merchant){
            $role = 'merchant';
            $token_key = config('site.merchant_login_token');
        }
        if($event->user instanceof \App\Admin\Admin){
            $role = 'admin';
            $token_key = config('site.admin_login_token');
        }
        $locate = ip_locate();
        $ip_address = $locate ? $locate['ip'] : ip_addr();
        $user_agent = \Agent::getUserAgent();
        $time = time();
        $login_token = md5(sprintf("%s@%s@%s@%s",$ip_address,$user_agent, $event->user->id,$time));
        \Session::put($token_key, $login_token);
        $event->user->last_login = date('Y-m-d H:i:s');
        $event->user->last_ip = $ip_address;
        $event->user->login_token = $login_token;
        $event->user->online = 1;
        $event->user->save();

        $log = [
            'role'=> $role,
            'uid'=> $event->user->id,
            'name'=> $event->user->nick_name,
            'action'=> '登录后台',
            'ip' => $ip_address,
            'locate' => $locate ? $locate['region'].'.'.$locate['city'].'-'.$locate['isp'] : '本机地址',
            'user_agent' => $user_agent,
        ];
        \App\Models\LoginLog::create($log);
    }
}

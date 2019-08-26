<?php

namespace App\Http\Middleware;

use App\Libs\Game\Models\Game;
use App\Libs\Merchant\Models\MerchantGame;
use App\Models\Menu;
use Closure;

class SystemInitialize
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
            $menu_key = config('site.admin_menu_key');
        }else if($guard == 'merchant'){
            $menu_key = config('site.merchant_menu_key');
            $user = \Auth::guard($guard)->user();
            $admin = FALSE;
            switch ($user->role->code){
                case 'shareholder':
                    $user_id = $user->parent->id;
                    break;
                case 'agent':
                    $user_id = $user->parent()->parent->id;
                    break;
                case 'proxy':
                    $user_id = $user->parent()->parent()->parent->id;
                    break;
                case 'company':
                    $user_id = $user->id;
                    break;
                case 'admin':
                    $admin = TRUE;
                    break;
            }
            if($admin){
                $merchant_games = Game::where('status', 1)->with('groups')->get()->toArray();
            }else{
                $merchant_games = MerchantGame::where([['merchant_id',$user_id],['status',1]])->with('groups')->get()->toArray();
            }
            \Session::put(config('site.merchant_game_key'),$merchant_games);
        }
        $menus = Menu::where('role', $guard)->whereNull('parent_id')->with('children')->get()->toArray();
        \Session::put($menu_key, $menus);

        return $next($request);
    }
}
